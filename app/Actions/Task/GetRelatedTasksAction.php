<?php

namespace App\Actions\Task;

use App\Models\Task;
use App\Support\RelatedTask;

class GetRelatedTasksAction
{
    public static function run(Task $task)
    {
        $collection = $task->relatedTo->concat($task->relatedFrom);

        $formatted = $collection->map(fn($c) => [
            'id' => $c->id,
            'title' => $c->title,
            'key' => $c->display_key,
            'done' => $c->isResolved(),
            'relation' => $c->pivot->related_from_id == $c->id
                ? RelatedTask::INVERSE_RELATIONS[$c->pivot->relationship]
                : RelatedTask::RELATIONS[$c->pivot->relationship],
            '_links' => [
                'self' => route('tasks.show', [$c->project_id, $c->display_key]),
            ],

        ]);

        return $formatted->groupBy('relation');
    }
}
