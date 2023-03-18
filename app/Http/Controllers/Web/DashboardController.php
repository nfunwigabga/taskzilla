<?php

namespace App\Http\Controllers\Web;

use App\Actions\Task\GetOpenTasksReportedByUserAction;
use App\Actions\Task\GetUserOpenTasksAction;
use App\Actions\Task\GetUserRecentlyClosedTasksAction;
use App\Actions\User\GetAllUsersAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserResource;
use Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'members' => UserResource::collection(GetAllUsersAction::run(['perPage' => 1000])),
            'tasks' => [
                'open' => TaskResource::collection(GetUserOpenTasksAction::run(Auth::user())),
                'reported' => TaskResource::collection(GetOpenTasksReportedByUserAction::run(Auth::user())),
                'resolved' => TaskResource::collection(GetUserRecentlyClosedTasksAction::run(Auth::user())),
            ],
        ]);

    }
}
