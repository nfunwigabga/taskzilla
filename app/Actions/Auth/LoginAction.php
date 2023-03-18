<?php

namespace App\Actions\Auth;

use App\Data\Auth\LoginData;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginAction
{
    /**
     * @return void
     *
     * @throws ValidationException
     */
    public static function run(LoginData $data)
    {
        $disabled = CheckIfAccountIsDisabledAction::run($data->email);

        if ($disabled) {
            throw ValidationException::withMessages([
                'email' => 'Account has been disabled',
            ]);
        }

        self::ensureIsNotRateLimited();
        if (! Auth::attempt($data->toArray())) {
            RateLimiter::hit(self::throttleKey());
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
        RateLimiter::clear(self::throttleKey());
    }

    /**
     * @return void
     *
     * @throws ValidationException
     */
    public static function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts(self::throttleKey(), 5)) {
            return;
        }
        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn(self::throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public static function throttleKey()
    {
        return Str::transliterate(Str::lower(request()->input('email')).'|'.request()->ip());
    }
}
