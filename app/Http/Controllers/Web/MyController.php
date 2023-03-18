<?php

namespace App\Http\Controllers\Web;

use App\Actions\My\GetMyTasksAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MyController extends Controller
{
    public function tasks(Request $request)
    {
        $filters = $request->only('q');

        $tasks = GetMyTasksAction::run(Auth::user(), $filters);

        return Inertia::render('My/Tasks', [
            'tasks' => TaskResource::collection($tasks),
            'filters' => $filters,
        ]);
    }
}
