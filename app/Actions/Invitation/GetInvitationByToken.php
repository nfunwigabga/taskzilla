<?php

namespace App\Actions\Invitation;

use App\Models\Invitation;

class GetInvitationByToken
{
    public static function run(string $token = null)
    {
        return Invitation::whereToken($token)->first();
    }
}
