<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\Question;
use RuntimeException;

class ExamService
{
    public function checkExamsQuestions($exam_id)
    {
        $exam = Exam::find($exam_id);

        if (!$exam) {
            throw new RuntimeException('Exam not found');
        }

        // Count the number of questions for the given exam_id
        $questionCount = Question::where('exam_id', $exam_id)->count();

        // Compare with the maximum allowed number of questions
        if ($questionCount + 1 > $exam->num_of_questions) {
            throw new RuntimeException('Question limit for this exam has been reached');
        }

        return $exam;
    }
}
