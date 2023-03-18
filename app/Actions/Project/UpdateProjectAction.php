<?php

namespace App\Actions\Project;

use App\Data\Project\UpdateProjectData;
use App\Models\Project;
use App\Models\User;
use App\Notifications\UserAddedToProjectNotification;

class UpdateProjectAction
{
    public static function run(UpdateProjectData $data, Project $project)
    {
        $project->update([
            'name' => $data->name ?? $project->name,
            'description' => $data->description ?? $project->description,
            'color' => $data->color ?? $project->color,
            'icon' => $data->icon ?? $project->icon,
            'start_date' => $data->start_date ?? $project->start_date,
            'due_date' => $data->due_date ?? $project->due_date,
        ]);

        if ($data->members) {
            $current_members = $project->members->pluck('id');
            $new_members = collect($data->members)->diff($current_members);

            $project->members()->sync($data->members);

            if (!$new_members->isEmpty()) {
                foreach (User::findMany($new_members->toArray()) as $user) {
                    $user->notify(new UserAddedToProjectNotification($project));
                }
            }

        }

    }
}
