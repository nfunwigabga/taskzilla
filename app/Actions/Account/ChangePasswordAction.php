<?php

namespace App\Actions\Account;

use App\Data\Account\ChangePasswordData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordAction
{
    public static function run(ChangePasswordData $data)
    {
        Auth::user()->update([
            'password' => Hash::make($data->new_password),
        ]);
    }
}
