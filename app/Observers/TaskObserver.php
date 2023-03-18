<?php

namespace App\Observers;

use App\Actions\Project\GetProjectByIdAction;
use App\Models\Task;

class TaskObserver
{
    public function creating(Task $task)
    {
        $project = GetProjectByIdAction::run($task->project_id);
        $task_number = $project->tasks()->max('task_number') + 1;
        $sort_order = $project->tasks()->max('sort_order') + 1;
        $task->task_number = $task_number;
        $task->sort_order = $sort_order;
        $task->display_key = "{$project->code}-{$task_number}";
    }
}
