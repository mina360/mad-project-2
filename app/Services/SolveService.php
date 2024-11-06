<?php

namespace App\Services;

use App\Models\Solve;

class SolveService
{
    public function createSolve($request, $exam_student)
    {
        $solve = Solve::create([
            'exam_student_id' => $exam_student->id,
            'question_id' => $request['question_id'],
            'answer_id' => $request['answer_id'],
        ]);

        return $solve;
    }
}
