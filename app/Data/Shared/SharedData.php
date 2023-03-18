<?php

namespace App\Data\Shared;

use App\Http\Resources\ProjectResource;
use Auth;
use Closure;
use Spatie\LaravelData\Data;

class SharedData extends Data
{
    public function __construct(
        public ?Closure          $auth = null,
        public ?NotificationData $notification = null
    )
    {
        $this->fill();
    }

    protected function fill(): void
    {
        if (session('notification')) {
            $this->notification = new NotificationData(
                ...session('notification')
            );
        }


        $loggedIn = Auth::check();

        $this->auth = fn() => [
            'loggedIn' => $loggedIn,
            'user' => fn() => $loggedIn ? UserData::from(Auth::user()) : null,
            'projects' => $loggedIn ?
                ProjectResource::collection(
                    Auth::user()->projects->load('members', 'codes', 'owner')
                ) : [],
        ];
    }
}
