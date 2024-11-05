<?php

namespace App\Services;


use App\Models\Exam;
use App\Models\Question;
use RuntimeException;
use Exception;
use Illuminate\Support\Facades\Auth;

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

    public function createExam($request)
    {
        if (Auth::user()->role != 'teacher') {
            throw new Exception('You cannot add an exam.');
        }

        $exam = Exam::create([
            'teacher_id' => Auth::id(),
            'title' => $request->title,
            'num_of_questions' => $request->num_of_questions
        ]);

        return $exam;
    }

    public function deleteExam($exam)
    {
        if (!$this->verifyExamOwner($exam)) {
            throw new Exception('You cannot delete this exam.');
        }

        $exam->delete();

        return $exam;
    }

    public function verifyExamOwner($exam)
    {
        return $exam->teacher_id == Auth::id();
    }

}
