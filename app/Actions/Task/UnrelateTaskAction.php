<?php

namespace App\Actions\Task;

use App\Models\Task;

class UnrelateTaskAction
{
    public static function run(Task $task, $relatedId)
    {
        $task->relatedFrom()->detach($relatedId);
        $task->relatedTo()->detach($relatedId);
    }
}
