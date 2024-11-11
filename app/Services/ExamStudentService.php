<?php

namespace App\Services;

use App\Enums\ExamStatus;
use App\Models\ExamStudent;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class ExamStudentService
{
    public function createExamStudent($exam_id)
    {
        $student = Auth::user();
        $exam_student = ExamStudent::firstOrCreate([
            'exam_id' => $exam_id,
            'student_id' => 1,
            'score' => 0,
            'status' => ExamStatus::InProgress,
            'attempted_at' => now(),
            'attempt' => 1
        ]);
        $exam_student->incrementAttempt();

        return $exam_student;
    }
}
