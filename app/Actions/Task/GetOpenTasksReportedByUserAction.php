<?php

namespace App\Actions\Task;

use App\Data\Task\TaskFilterData;
use App\Filters\Tasks\TaskBelongsToUserProjectsFilter;
use App\Filters\Tasks\UserTasksFilter;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Pipeline;

class GetOpenTasksReportedByUserAction
{
    public static function run(User $user)
    {

        $data = TaskFilterData::from([
            'builder' => Task::query(),
            'filters' => [],
            'user_id' => $user->id,
        ]);

        return Pipeline::send($data)
            ->through([
                UserTasksFilter::class . ':reporter',
                TaskBelongsToUserProjectsFilter::class,
            ])
            ->then(fn($data) => $data->builder)
            ->with(['section', 'type', 'priority', 'assignee'])
            ->open()
            ->oldest()
            ->get();
    }
}
