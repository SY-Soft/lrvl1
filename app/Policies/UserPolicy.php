<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 1;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        /**
         * 1 - admin
         * 2 - editor
         * 3 - author
         */
        if($user->id==1 || $user->id==$model->id) return true;
        if ($user->role === 1 && ($model->role > 1 || $model->role == 0)) return true;
        if ($user->role === 2 && ($model->role > 2 || $model->role == 0)) return true;

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        /**
         * 1 - admin
         * 2 - editor
         * 3 - author
         */
        if($model->id==1) return false;
        if($user->id==1) return true;
        if ($user->role === 1 && ($model->role > 1 || $model->role == 0)) return true;
        if ($user->role === 2 && ($model->role > 2 || $model->role == 0)) return true;

        return false;
    }

    public function promote(User $user, User $model): bool
    {
        // 1 - admin  2 - editor 3 - author
        if ($user->id === $model->id) return false;
        if ($user->id === 1 && $model->role !== 1) return true;
        if ($user->role === 1 && in_array($model->role, [0, 3])) return true;
        if ($user->role === 2 && $model->role===0) return true;

        return false;

    }

    public function demote(User $user, User $model): bool
    {
        // dd($user->id .'=='. $model->id);
        // 1 - admin  2 - editor 3 - author
        if ($user->id === $model->id) return false;
        if ($user->id === 1 && ($model->role !== 3 && $model->role !== 0)) return true;
        if ($user->role === 1 && in_array($model->role, [2, 3])) return true;
        if ($user->role === 2 && $model->role===3) return true;
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
