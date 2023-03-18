<?php

namespace App\Http\Controllers\Web\Auth;

use App\Actions\Auth\CreateUserFromInvitationAction;
use App\Actions\Invitation\GetInvitationByToken;
use App\Actions\User\GetUserByEmailAction;
use App\Data\Auth\RegisterUserData;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Redirect;

class RegisterController extends Controller
{
    /**
     * @return RedirectResponse|\Inertia\Response
     */
    public function create(Request $request)
    {
        $token = $request->query('invitation');
        $invitation = GetInvitationByToken::run($token);

        if (! $invitation || ($invitation && GetUserByEmailAction::run($invitation->recipient_email))) {
            return Redirect::route('login');
        }

        return Inertia::render('Auth/Register', [
            'email' => $invitation?->recipient_email,
            'invitation' => $token,
        ]);
    }

    /**
     * @return mixed
     *
     * @throws ValidationException
     */
    public function store(RegisterUserData $data)
    {
        if ($data->invitation) {
            $invitation = GetInvitationByToken::run($data->invitation);

            if (! $invitation) {
                throw ValidationException::withMessages([
                    'email' => 'Invalid invitation token',
                ]);
            }

            $user = CreateUserFromInvitationAction::run(data: $data, invitation: $invitation);
            Auth::login($user);

            return Redirect::to(RouteServiceProvider::HOME)
                ->success('Welcome aboard!');
        }

        return Redirect::to(RouteServiceProvider::HOME)
            ->error('Unable to complete registration');
    }
}
