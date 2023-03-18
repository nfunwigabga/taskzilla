<?php

namespace App\Actions\Invitation;

use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;

class CreateInvitationAction
{
    public static function run(string $email)
    {
        return Invitation::create([
            'sender_id' => Auth::id(),
            'recipient_email' => $email,
            'token' => md5(uniqid(microtime())),
        ]);
    }
}
