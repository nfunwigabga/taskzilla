<?php

namespace App\Actions\Task;

use App\Models\Task;
use App\Models\User;

class GetUserRecentlyClosedTasksAction
{
    public static function run(User $user)
    {
        return Task::where('assignee_id', $user->id)
            ->whereBetween('resolved_at', [now()->subDays(10), now()])
            ->with(['type', 'section', 'assignee', 'priority'])
            ->orderBy('resolved_at', 'desc')
            ->get();
    }
}
