<?php

namespace App\Actions\Auth;

use App\Actions\Invitation\DeleteInvitationAction;
use App\Data\Auth\RegisterUserData;
use App\Enums\Roles;
use App\Models\Invitation;
use App\Models\User;
use Hash;

class CreateUserFromInvitationAction
{
    public static function run(RegisterUserData $data, Invitation $invitation)
    {
        $user = User::create([
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'email' => $data->email,
            'role' => Roles::MEMBER,
            'password' => Hash::make($data->password),
        ]);

        $user->markEmailAsVerified();

        DeleteInvitationAction::run($invitation);

        return $user;
    }
}
