<?php

namespace App\Actions\Project;

use App\Models\Project;
use App\Models\User;

class ToggleFavoriteStatusAction
{
    public static function run(Project $project, User $user)
    {
        $project->members()->updateExistingPivot($user->id, [
            'is_favorite' => ! $user->hasFavedProject($project),
        ]);
    }
}
