<?php

namespace App\Filters\Tasks;

use App\Data\Task\TaskFilterData;
use Closure;

class TaskBelongsToUserProjectsFilter
{
    public function handle(TaskFilterData $data, Closure $next)
    {
        $data->builder->whereHas('project', function ($query) use ($data) {
            $query->whereHas('members', fn($q) => $q->where('id', $data->user_id));
        });

        return $next($data);
    }
}
