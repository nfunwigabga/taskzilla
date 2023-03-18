<?php

namespace App\Data\Account;

use App\Rules\CheckSamePassword;
use Illuminate\Validation\Rules\Password;
use Spatie\LaravelData\Data;

class ChangePasswordData extends Data
{
    public string $new_password;

    public static function rules(): array
    {
        return [
            'current_password' => ['required', new CheckSamePassword(true)],
            'new_password' => ['required', 'confirmed', Password::default(), new CheckSamePassword(false)],
        ];
    }
}
