<?php

namespace App\Actions\Task;

use App\Data\Task\UpdateTaskData;
use App\Models\Task;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Support\Facades\Auth;

class UpdateTaskAction
{
    public static function run(UpdateTaskData $data, Task $task)
    {
        $task->update([
            'title' => $data->title ?? $task->title,
            'description' => $data->description ?? $task->description,
            'section_id' => $data->section ?? $task->section_id,
            'priority_id' => $data->priority ?? $task->priority_id,
            'type_id' => $data->type ?? $task->type_id,
            'due_date' => $data->field == 'due_date' ? $data->due_date : $task->due_date,
            'assignee_id' => $data->field == 'assignee' ? $data->assignee : $task->assignee_id,
        ]);

        if ($data->field == 'assignee'
            && $task->fresh()->assignee
            && $task->fresh()->assignee_id !== Auth::id()) {
            $task->fresh()->assignee->notify(new TaskAssignedNotification($task));
        }
    }
}
