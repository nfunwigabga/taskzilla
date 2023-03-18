<?php

namespace App\Actions\Auth;

use App\Data\Auth\ResetPasswordData;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordAction
{
    public static function run(ResetPasswordData $data)
    {
        return Password::reset(
            $data->toArray(),
            function ($user) use ($data) {
                $user->update([
                    'password' => Hash::make($data->password),
                    'remember_token' => Str::random(60),
                ]);
                event(new PasswordReset($user));
            }
        );
    }
}
