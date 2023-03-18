<?php

namespace App\Http\Controllers\Web\Account;

use App\Actions\Account\ChangePasswordAction;
use App\Actions\Account\DeleteOtherUserSessionsAction;
use App\Data\Account\ChangePasswordData;
use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AccountSecurityController extends Controller
{
    /**
     * @return mixed
     *
     * @throws AuthenticationException
     */
    public function changePassword(Request $request, ChangePasswordData $data)
    {
        ChangePasswordAction::run($data);
        DeleteOtherUserSessionsAction::run($data->new_password, $request);

        return Redirect::back()->success('Password changed successfully');
    }
}
