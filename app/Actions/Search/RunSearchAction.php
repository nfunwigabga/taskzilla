<?php

namespace App\Actions\Search;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RunSearchAction
{

    public static function run(string $query = null)
    {
        $user_projects = Auth::user()
            ->projects
            ->pluck('id')
            ->toArray();

        $users = User::search($query)
            ->get()
            ->take(10)
            ->map(fn($user) => [
                'type' => 'USER',
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar,
                'link' => route('users.show', $user->id)
            ]);

        $projects = Project::search($query)
            ->whereIn('id', $user_projects)
            ->get()
            ->take(10)
            ->map(fn($project) => [
                'type' => 'PROJECT',
                'id' => $project->id,
                'name' => $project->name,
                'color' => $project->color,
                'icon' => $project->icon,
                'link' => route('projects.show', $project->id)

            ]);

        $tasks = Task::search($query)
            ->whereIn('project_id', $user_projects)
            ->get()
            ->take(10)
            ->map(fn($task) => [
                'type' => 'TASK',
                'id' => $task->id,
                'name' => $task->title,
                'display' => $task->display_key,
                'color' => $task->type?->color,
                'link' => route('tasks.show', [$task->project_id, $task->display_key])
            ]);


        return $users
            ->concat($projects)
            ->concat($tasks);
    }

}
