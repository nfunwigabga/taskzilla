<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Project\GetAllProjectsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminProjectsController extends Controller
{

    public function index(Request $request)
    {
        $projects = GetAllProjectsAction::run($request->all());

        return Inertia::render('Admin/Projects', [
            'projects' => ProjectResource::collection($projects),
            'filters' => $request->all(),
        ]);
    }
}
