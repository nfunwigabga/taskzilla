<?php

namespace App\Http\Controllers\Web;

use App\Actions\Task\RelateTasksAction;
use App\Actions\Task\SearchRelatedTaskAction;
use App\Actions\Task\UnrelateTaskAction;
use App\Data\Task\RelateTasksData;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Redirect;

class TaskRelationController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function getUnrelatedTasks(Request $request, Project $project, Task $task)
    {
        $tasks = SearchRelatedTaskAction::run($project, $task, $request->keyword);

        return TaskResource::collection($tasks);
    }

    /**
     * @return RedirectResponse
     */
    public function relate(RelateTasksData $data, Project $project, Task $task)
    {
        RelateTasksAction::run($data, $task);

        return Redirect::back();
    }

    /**
     * @return RedirectResponse
     */
    public function unrelate(Request $request, Project $project, Task $task)
    {
        UnrelateTaskAction::run(task: $task, relatedId: $request->related);

        return Redirect::back();
    }
}
