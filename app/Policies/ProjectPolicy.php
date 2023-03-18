<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, $model)
    {
        if ($user->isProjectAdminOrOwner($model) || $user->isAdminOrSuperAdmin()) {
            return true;
        }
    }

    public function manage(User $user, Project $project)
    {
        return $user->isProjectAdminOrOwner($project);
    }

    public function view(User $user, Project $project)
    {
        return $project->members->contains($user);
    }

    public function update(User $user, Project $project)
    {
        return $project->members->contains($user);
    }

    public function delete(User $user, Project $project)
    {
        //
    }

    public function restore(User $user, Project $project)
    {
        //
    }

    public function forceDelete(User $user, Project $project)
    {
        //
    }

    public function leave(User $user, Project $project)
    {
        $user->isGuestOnProject($project);
    }
}
