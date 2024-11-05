<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;

class AnswerPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function create(User $user)
    {
        return $user->role === 'teacher';
    }

    public function delete(User $user, Answer $answer)
    {
        return $user->role === 'teacher' && $user->id === $answer->question->user_id;
    }
}
