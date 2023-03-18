<?php

namespace App\Http\Controllers\Web\Account;

use App\Actions\Account\UpdateUserProfileAction;
use App\Actions\Account\UpdateUserSettingsAction;
use App\Data\Account\UpdateUserProfileData;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AccountProfileController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function update(UpdateUserProfileData $data)
    {
        UpdateUserProfileAction::run($data);

        return Redirect::back()->success('Profile info updated!');
    }

    /**
     * @return RedirectResponse
     */
    public function avatar(Request $request)
    {
        Auth::user()->updateProfilePhoto($request->file('avatar'));

        return Redirect::back()->success('Profile image uploaded');
    }

    /**
     * @return mixed
     */
    public function notifications(Request $request)
    {
        UpdateUserSettingsAction::run($request->all());

        return Redirect::back()->success('Settings updated');
    }
}
