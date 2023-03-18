<?php

namespace App\Actions\Account;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteOtherUserSessionsAction
{
    /**
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public static function run(string $password, Request $request)
    {
        Auth::logoutOtherDevices($password);

        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();
    }
}
