<?php

namespace App\Actions\Task;

use App\Data\Task\CreateTaskData;
use App\Models\Project;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Support\Facades\Auth;

class CreateTaskAction
{
    public static function run(Project $project, CreateTaskData $data)
    {
        $task = $project->tasks()->create([
            'title' => $data->title,
            'description' => $data->description,
            'section_id' => $data->section,
            'priority_id' => $data->priority,
            'reporter_id' => Auth::id(),
            'assignee_id' => $data->assignee,
            'type_id' => $data->type,
            'parent_id' => $data->parent,
        ]);

        if ($task->fresh()->assignee) {
            $task->fresh()->assignee->notify(new TaskAssignedNotification($task));
        }

        return $task;
    }
}
