<?php

namespace App\Actions\Account;

use App\Data\Account\UpdateUserProfileData;
use Illuminate\Support\Facades\Auth;

class UpdateUserProfileAction
{
    public static function run(UpdateUserProfileData $data)
    {
        return tap(Auth::user())->update([
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'job_title' => $data->job_title,
            'about' => $data->about,
        ]);
    }
}
