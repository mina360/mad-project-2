<?php

namespace App\Services;

use App\Enums\ExamStatus;
use App\Models\ExamStudent;
use Illuminate\Support\Facades\Auth;

class ExamStudentService
{
    public function createExamStudent($exam)
    {
        $student = Auth::user();
        $exam_student = ExamStudent::firstOrCreate([
            'exam_id' => $exam->id,
            'student_id' => $student->id,
            'score' => 0,
            'status' => ExamStatus::InProgress,
        ]);
        $exam_student->incrementAttempt();

        return $exam_student;
    }
}
