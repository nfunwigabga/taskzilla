<?php

namespace App\Actions\Auth;

use App\Actions\User\GetUserByEmailAction;

class CheckIfAccountIsDisabledAction
{
    public static function run(string $email)
    {
        $user = GetUserByEmailAction::run($email);
        if (! $user) {
            return false;
        }

        return ! $user->is_active;
    }
}
