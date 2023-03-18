<?php

namespace App\Data\Install;

use Illuminate\Validation\Rules\Password;
use Spatie\LaravelData\Data;

class CreateAdminUserData extends Data
{

    public string $first_name;

    public string $last_name;

    public string $email;

    public string $password;

    public static function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }


}
