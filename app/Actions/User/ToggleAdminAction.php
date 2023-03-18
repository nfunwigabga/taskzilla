<?php

namespace App\Actions\User;

use App\Enums\Roles;
use App\Models\User;

class ToggleAdminAction
{
    public static function run(User $user)
    {
        return tap($user)->update([
            'role' => $user->role == Roles::ADMIN
                ? Roles::MEMBER
                : Roles::ADMIN,
        ]);
    }
}
