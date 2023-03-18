<?php

namespace App\Http\Controllers\Web;

use App\Actions\Task\CreateTaskAction;
use App\Actions\Task\GetRelatedTasksAction;
use App\Actions\Task\ToggleResolvedStatusAction;
use App\Actions\Task\UpdateTaskAction;
use App\Data\Task\CreateTaskData;
use App\Data\Task\UpdateTaskData;
use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\ProjectResource;
use App\Models\Task;
use App\Models\Project;
use App\Support\RelatedTask;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Momentum\Modal\Modal;
use Redirect;

class TaskController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function store(CreateTaskData $data, Project $project)
    {
        CreateTaskAction::run($project, $data);

        return Redirect::back();
    }

    /**
     * @return RedirectResponse
     */
    public function update(UpdateTaskData $data, Project $project, Task $task)
    {
        UpdateTaskAction::run($data, $task);

        return Redirect::back();
    }

    /**
     * @return Modal
     */
    public function show(Project $project, Task $task)
    {
        $task = $task->load([
            'section', 'priority', 'type', 'reporter', 'assignee', 'media',
            'children', 'children.type', 'children.priority', 'children.assignee',
            'comments', 'parent',
        ]);

        $relatedTasks = GetRelatedTasksAction::run($task);

        return Inertia::modal('Tasks/Show')->with([
            'task' => TaskResource::make($task),
            'can_resolve' => $task->can_resolve,
            'activities' => ActivityResource::collection($task->activities),
            'project' => new ProjectResource($project->load('members')),
            'relatedTasks' => $relatedTasks,
            'relations' => RelatedTask::getRelations(),
        ])->baseRoute('projects.board', [$project]);
    }

    /**
     * @return mixed
     */
    public function toggleResolvedStatus(Project $project, Task $task)
    {
        ToggleResolvedStatusAction::run($task);

        return Redirect::back()->success('Status updated successfully');
    }
}
