<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NewsPolicy
{


    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, News $news): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // dd($user);
        return in_array($user->role, [1, 2, 3]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, News $news): bool
    {
        // admin может всё
        if ($user->role == 1) {
            return true;
        }

        // editor
        if ($user->role == 2) {

            // свои новости
            if ($user->id === $news->user_id) {
                return true;
            }

            // новости авторов
            if ($news->user && $news->user->role == 3) {
                return true;
            }
        }

        // author только свои
        if ($user->role == 3) {
            return $user->id === $news->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, News $news): bool
    {
        // admin может всё
        if ($user->role == 1) {
            return true;
        }

        // editor
        if ($user->role == 2) {

            // свои новости
            if ($user->id === $news->user_id) {
                return true;
            }

            // новости авторов
            if ($news->user && $news->user->role == 3) {
                return true;
            }
        }

        // author только свои
        if ($user->role == 3) {
            return $user->id === $news->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, News $news): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, News $news): bool
    {
        return false;
    }
}
