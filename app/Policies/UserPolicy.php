<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $user, User $model)
    {
        return true;
    }

    public function delete(User $user, User $model)
    {
        return $user->isAdminOrSuperAdmin();
    }

    public function restore(User $user, User $model)
    {
        return $user->isAdminOrSuperAdmin();
    }

    public function forceDelete(User $user, User $model)
    {
        return $user->isAdminOrSuperAdmin();
    }
}
