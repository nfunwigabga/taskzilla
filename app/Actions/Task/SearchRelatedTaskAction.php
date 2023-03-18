<?php

namespace App\Actions\Task;

use App\Models\Task;
use App\Models\Project;

class SearchRelatedTaskAction
{
    public static function run(Project $project, Task $task, string $keyword)
    {
        $allDescendantsAndSelf = $task->descendantsAndSelf()->pluck('id');
        $ancestors = $task->ancestors()->pluck('id');

        return $project->tasks()
            ->with('type')
            ->whereNotIn('id', $allDescendantsAndSelf)
            ->whereNotIn('id', $ancestors)
            ->where(function ($q) use ($keyword) {
                $q->where('title', 'REGEXP', $keyword)
                    ->orWhere('display_key', 'REGEXP', $keyword);
            })
            ->get()
            ->filter(fn($i) => !$i->isRelatedTo($task));
    }
}
