<?php

namespace App\Actions\User;

use App\Models\User;

class ToggleStatusAction
{
    public static function run(User $user)
    {
        $currently_active = $user->is_active;

        return tap($user)->update([
            'is_active' => ! $currently_active,
            'should_be_logged_out' => $currently_active,
        ]);
    }
}
