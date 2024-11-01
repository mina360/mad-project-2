<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;

class QuestionPolicy
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

    public function delete(User $user, Question $question)
    {
        return $user->id === $question->user_id && $user->role === 'teacher';
    }
}
