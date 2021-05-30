<?php

namespace App\Policies;

use App\Models\TodoTask;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoTaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TodoTask  $todoTask
     * @return mixed
     */
    public function update(User $user, TodoTask $todoTask)
    {
        return $user->id === $todoTask->todo->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TodoTask  $todoTask
     * @return mixed
     */
    public function delete(User $user, TodoTask $todoTask)
    {
        return $user->id === $todoTask->todo->user_id;
    }

}
