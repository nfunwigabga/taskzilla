<?php

namespace App\Actions\Account;

use Illuminate\Support\Facades\Auth;

class UpdateUserSettingsAction
{
    public static function run(array $settings)
    {
        foreach ($settings as $key => $value) {
            setting()->set($key, $value, Auth::id());
        }
        setting()->save(Auth::id());
    }
}
