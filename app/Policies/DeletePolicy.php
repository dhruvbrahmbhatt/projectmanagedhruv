<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeletePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function deleteTask(User $user, Tasks $tasks)
    {
        return $user->id === $tasks->user_id;
    }

    public function deleteComment(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }

    public function editTask(User $user, Tasks $tasks)
    {
        return $user->id === $tasks->user_id;
    }
}
