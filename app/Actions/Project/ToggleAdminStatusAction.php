<?php

namespace App\Actions\Project;

use App\Models\Project;
use App\Models\User;
use App\Notifications\UserHasBeenMadeProjectAdminNotification;

class ToggleAdminStatusAction
{
    public static function run(Project $project, User $user)
    {
        if ($user->isProjectOwner($project)) {
            return;
        }
        $isProjectAdmin = $user->isProjectAdmin($project);
        $project->members()->updateExistingPivot($user->id, [
            'is_admin' => !$isProjectAdmin,
        ]);
        if (!$isProjectAdmin) {
            $user->notify(new UserHasBeenMadeProjectAdminNotification($project));
        }
    }
}
