<?php

namespace App\Actions\Invitation;

use App\Models\Invitation;

class GetAllInvitationsAction
{
    public static function run()
    {
        return Invitation::all();
    }
}
