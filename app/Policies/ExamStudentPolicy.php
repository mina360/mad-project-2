<?php

namespace App\Policies;

use App\Models\ExamStudent;
use App\Models\User;

class ExamStudentPolicy
{
    public function viewResult(User $user, ExamStudent $exam_student)
    {
        return $user->id === $exam_student->student_id;
    }
}
