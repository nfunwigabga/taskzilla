<?php

namespace App\Actions\Install;

use App\Data\Install\CreateAdminUserData;
use App\Enums\Roles;
use App\Models\User;
use Hash;

class CreateAdminUserAction
{

    public static function run(CreateAdminUserData $data)
    {
        return User::create([
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'role' => Roles::SUPER_ADMIN
        ]);
    }

}
