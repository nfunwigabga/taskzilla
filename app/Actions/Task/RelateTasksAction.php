<?php

namespace App\Actions\Task;

use App\Data\Task\RelateTasksData;
use App\Models\Task;

class RelateTasksAction
{
    public static function run(RelateTasksData $data, Task $task)
    {
        $task->relatedTo()
            ->syncWithoutDetaching([
                $data->related_task => ['relationship' => $data->relation],
            ]);
    }
}
