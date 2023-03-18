<?php

namespace App\Http\Controllers\Web;

use App\Actions\User\GetAllUsersAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = GetAllUsersAction::run(['perPage' => 10000]);

        return UserResource::collection($users);
    }
}
