<?php

namespace App\Policies;

use App\Models\User;
use App\Models\post;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
    return true;
    }
    /**
     * Determine whether the user can view the model.
     */
    // public function view(User $user, User $model): bool
    // {
    // return $user->admin() || $user->user() || $user->member();
    // }
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->admin()|| $user->user() || $user->member();
    }
    /**
     * Determine whether the user can update the model.
     */
    // public function update(User $user, User $model): bool
    // {
    //     return $user->admin()|| $user->user();

    // }
    public function delete(User $user): bool
    {
        return true;
    }
    /**
     * Determine whether the user can delete the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->admin()|| $user->user();
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
        return $user->admin()|| $user->user();
    }
  
    public function restore(User $user): bool
    {
        return $user->admin() || $user->user();
    }

    public function reorder(User $user): bool
    {
        return $user->admin()|| $user->user();
    }

}