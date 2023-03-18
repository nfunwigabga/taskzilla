<?php

namespace App\Actions\User;

use App\Models\User;

class GetUserByEmailAction
{
    public static function run(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
