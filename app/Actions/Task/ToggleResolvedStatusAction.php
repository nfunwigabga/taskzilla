<?php

namespace App\Actions\Task;

use App\Models\Task;
use App\Notifications\TaskResolvedNotification;
use Auth;

class ToggleResolvedStatusAction
{
    public static function run(Task $task)
    {
        $task = tap($task)->update([
            'resolved_at' => $task->resolved_at ? null : now(),
        ]);

        if ($task->fresh()->isResolved()) {
            if ($task->assignee && $task->assignee_id !== Auth::id()) {
                $task->assignee->notify(new TaskResolvedNotification($task, Auth::user()));
            }

            if ($task->reporter_id !== Auth::id()) {
                $task->reporter->notify(new TaskResolvedNotification($task, Auth::user()));
            }
        }
        return $task;
    }
}
