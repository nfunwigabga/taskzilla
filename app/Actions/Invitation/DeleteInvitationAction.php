<?php

namespace App\Actions\Invitation;

use App\Models\Invitation;

class DeleteInvitationAction
{
    public static function run(Invitation $invitation)
    {
        $invitation->delete();
    }
}
