<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NewsPolicy
{
    // пример от GPT

    /*
    public function update(User $user, News $news)
{
    return $user->id === $news->user_id;
}

public function delete(User $user, News $news)
{
    return $user->id === $news->user_id;
}

public function create(User $user)
{
    return true;
}
    */


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
    public function view(?User $user, News $news): bool
    {
      // dd($news->published);
        // Если новость опубликована — её может видеть любой человек
        if ($news->published) {
            return true;
        }

        // Если новость НЕ опубликована — смотрим права пользователя
        // Только автор + админ + редактор
        if ($user->id === $news->user_id) {
            return true;
        }

        // Админ (1) и Редактор (2) могут видеть все черновики
        return in_array($user->role, [1, 2]);
    }

    public function public(User $user, News $news): bool
    {
        // Автор новости + Админ + Редактор могут публиковать/снимать
        if ($user->id === $news->user_id) return true;
        if (in_array($user->role, [1, 2])) return true; // 1=admin, 2=editor

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
