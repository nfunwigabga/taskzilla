<?php

namespace App\Actions\Comment;

use App\Models\Task;

class GetTaskCommentsAction
{
    public static function run(Task $task)
    {
        return $task->comments()
            ->isRoot()
            ->with(['children' => fn($q) => $q->oldest()])
            ->whereNull('parent_id')
            ->latest()
            ->cursorPaginate(6);
    }
}
