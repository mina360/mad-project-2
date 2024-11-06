<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Exam;
use App\Models\Solve;
use App\Models\Answer;
use App\Models\Question;
use App\Enums\ExamStatus;
use App\Models\ExamStudent;
use Illuminate\Http\Request;
use App\Services\SolveService;
use App\Http\Requests\SolveRequest;
use App\Services\ExamStudentService;
use Illuminate\Support\Facades\Auth;

class SolveController extends Controller
{
    protected $solveService;
    protected $examStudentService;
    public function __construct(SolveService $solveService, ExamStudentService $examStudentService)
    {
        $this->solveService = $solveService;
        $this->examStudentService = $examStudentService;
    }

    public function takeExam(Exam $exam)
    {
        if (Auth::user()->role != 'student') {
            return new Exception("You are not allowed to take exams.");
        }

        $exam_student = $this->examStudentService->createExamStudent($exam);
        return response()->json([
            'Exam Student' => $exam_student
        ]);
    }
    public function addSolve(SolveRequest $request, Exam $exam)
    {
        if (Auth::user()->role != 'student') {
            return new Exception("You are not allowed to take exams.");
        }
        $exam_student = ExamStudent::where([
            'exam_id' => $exam->id,
            'student_id' => Auth::id(),
        ])->first();
        if (!$exam_student) {
            return new Exception("ExamStudent not found.");
        }
        $question = Question::find($request['question_id']);
        $student_answer = Answer::find($request['answer_id']);
        if (! $exam->isValidQuestion($question)) {
            return new Exception("Invalid question");
        }
        if (! $question->isValidAnswer($student_answer)) {
            return new Exception("Invalid answer");
        }
        $solve = $this->solveService->createSolve($request, $exam_student);

        $correct_questions = [];
        if ($student_answer->isCorrect()) {
            $exam_student->incrementCorrectAnswersCount();
            $correct_questions[] = $student_answer->question->id;
        }
        return response()->json([
            'Your solve' => $solve,
            'Correct questions' => $correct_questions
        ]);
    }
    public function calculateScore(ExamStudent $exam_student)
    {
        if (! $exam_student) {
            return new Exception("ExamStudent not found.");
        }
        $exam_student->updateScore($exam_student->correct_answers_count);
        $exam_student->updateExamStatus();
        return response()->json([
            'score' => $exam_student->score
        ]);
    }
}
