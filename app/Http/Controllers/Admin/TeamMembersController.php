<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Invitation\DeleteInvitationAction;
use App\Actions\Invitation\GetAllInvitationsAction;
use App\Actions\Invitation\ProcessInvitationsAction;
use App\Actions\User\GetAllUsersAction;
use App\Actions\User\GetUserByEmailAction;
use App\Actions\User\ToggleAdminAction;
use App\Actions\User\ToggleStatusAction;
use App\Data\Invitation\CreateInvitationData;
use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvitationResource;
use App\Http\Resources\UserResource;
use App\Models\Invitation;
use App\Models\User;
use App\Notifications\SendInvitationToNewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;
use Redirect;

class TeamMembersController extends Controller
{
    public function index(Request $request)
    {
        $users = GetAllUsersAction::run($request->all());

        return Inertia::render('Admin/Users', [
            'users' => UserResource::collection($users),
            'invitations' => InvitationResource::collection(GetAllInvitationsAction::run()),
            'filters' => $request->all(),
        ]);
    }

    public function invite(CreateInvitationData $data)
    {
        ProcessInvitationsAction::run($data);

        return Redirect::back()->success('Invitation sent');
    }

    public function resend(Invitation $invitation)
    {
        $recipient = GetUserByEmailAction::run($invitation->recipient_email);

        if (empty($recipient)) {
            Notification::route('mail', $invitation->recipient_email)
                ->notify(new SendInvitationToNewUser($invitation));
        }

        return Redirect::back()->success('Invitation re-sent');
    }

    public function destroy(Invitation $invitation)
    {
        DeleteInvitationAction::run($invitation);

        return Redirect::back()->success('Invitation deleted!');
    }

    public function toggleAdmin(User $user)
    {
        ToggleAdminAction::run($user);

        return Redirect::back()->success('Role changed!');
    }

    public function toggleStatus(User $user)
    {
        if ($user->role != Roles::SUPER_ADMIN) {
            ToggleStatusAction::run($user);
        }

        return Redirect::back()->success('Status changed!');
    }
}
