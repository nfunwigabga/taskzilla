<?php

namespace App\Http\Controllers\Web\Account;

use App\Actions\Account\UpdateUserSettingsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AccountPrivacySettingsController extends Controller
{
    /**
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Account/Privacy', [
            'user' => new UserResource(Auth::user()),
        ]);
    }

    /**
     * @return void
     */
    public function update(Request $request)
    {
        UpdateUserSettingsAction::run($request->all());
    }
}
