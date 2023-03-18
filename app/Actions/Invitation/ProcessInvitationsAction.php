<?php

namespace App\Actions\Invitation;

use App\Actions\User\GetUserByEmailAction;
use App\Data\Invitation\CreateInvitationData;
use App\Models\Invitation;
use App\Notifications\SendInvitationToNewUser;
use Illuminate\Support\Facades\Notification;

class ProcessInvitationsAction
{
    public static function run(CreateInvitationData $data)
    {
        foreach ($data->emails as $email) {
            if (Invitation::hasPendingInvite($email)) {
                continue;
            }

            $recipient = GetUserByEmailAction::run($email);

            if (empty($recipient)) {
                try {
                    $invitation = CreateInvitationAction::run($email);
                    Notification::route('mail', $email)
                        ->notify(new SendInvitationToNewUser($invitation));
                } catch (\Throwable $e) {
                    report($e);
                    continue;
                }

            }
        }
    }
}
