<?php

namespace App\Actions\Project;

use App\Models\Project;
use App\Models\User;
use App\Notifications\UserAddedToProjectNotification;

class ToggleProjectMembershipAction
{
    public static function run(Project $project, User $user)
    {
        if ($project->hasUser($user)) {
            $project->members()->detach($user->id);
        } else {
            $project->members()->attach($user->id);
            $user->notify(new UserAddedToProjectNotification($project));
        }
    }
}
