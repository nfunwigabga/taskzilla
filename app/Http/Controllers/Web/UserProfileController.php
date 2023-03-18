<?php

namespace App\Http\Controllers\Web;

use App\Actions\My\GetMyAssignedTasksAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserProfileController extends Controller
{
    /**
     * @return \Inertia\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);
        $filters = $request->only('q');
        $tasks = GetMyAssignedTasksAction::run($user, $filters);

        return Inertia::render('User/Profile', [
            'user' => UserResource::make($user),
            'tasks' => TaskResource::collection($tasks),
            'filters' => $filters,
            'projects' => ProjectResource::collection($user->projects),
        ]);
    }
}
