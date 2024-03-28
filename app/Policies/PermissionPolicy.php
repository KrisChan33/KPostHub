<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->admin();
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->admin();
    }
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->admin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->admin();
    }
    public function delete(User $user): bool
    {
        return $user->admin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->admin();
    }
    /**
     * Determine whether the user can restore the model.
     */
    public function restoreAny(User $user): bool
    {
        return $user->admin();
    }
    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->admin();
    }

    public function forceDelete(User $user): bool
    {
        return $user->admin();
    }

    public function restore(User $user): bool
    {
        return $user->admin();
    }

    public function reorder(User $user): bool
    {
        return $user->admin();
    }
}
