<?php

namespace App\Data\Task;

use Spatie\LaravelData\Data;

class RelateTasksData extends Data
{
    public string $relation;

    public string $related_task;

    public static function rules(): array
    {
        return [
            'relation' => ['required', 'string'],
            'related_task' => ['required', 'string'],
        ];
    }
}
