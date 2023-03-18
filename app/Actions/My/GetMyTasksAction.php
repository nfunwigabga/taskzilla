<?php

namespace App\Actions\My;

use App\Data\Task\TaskFilterData;
use App\Filters\Tasks\TaskBelongsToUserProjectsFilter;
use App\Filters\Tasks\KeywordFilter;
use App\Filters\Tasks\PriorityFilter;
use App\Filters\Tasks\UserTasksFilter;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Pipeline;

class GetMyTasksAction
{
    public static function run(User $user, array $filters)
    {
        $data = TaskFilterData::from([
            'builder' => Task::query(),
            'filters' => $filters,
            'user_id' => $user->id,
        ]);

        return Pipeline::send($data)
            ->through([
                KeywordFilter::class,
                PriorityFilter::class,
                UserTasksFilter::class,
                TaskBelongsToUserProjectsFilter::class,
            ])
            ->then(fn($data) => $data->builder)
            ->with(['type', 'priority', 'reporter', 'assignee'])
            ->paginate($filters['perPage'] ?? 10)
            ->withQueryString();
    }
}
