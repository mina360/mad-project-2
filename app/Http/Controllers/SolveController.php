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
    public function addAnswer(SolveRequest $request, Exam $exam)
    {
        $correct_answers_count = 0;
        $correct_questions = [];
        $question = Question::find($request['question_id']);
        $student_answer = Answer::find($request['answer_id']);
        if (! $exam->isValidQuestion($question)) {
            return new Exception("Invalid question");
        }
        if (! $question->isValidAnswer($student_answer)) {
            return new Exception("Invalid answer");
        }
        $exam_student = $examStudentService->createExamStudent($exam);
        $solve = $solveService->createSolveAndIncrementAttempt($request, $exam_student);
        if ($student_answer->isCorrect()) {
            $correct_answers_count += 1;
            $correct_questions[] = $student_answer->question->id;
            $exam_student->updateScore($correct_answers_count);
        }
        $exam_status = $correct_answers_count >= 60 ? "passed" : "failed";
        return response()->json([
            "student's solve" => $solve,
            'status' => $exam_status,
            'score/mark' => $correct_answers_count,
            'total questions' => $correct_questions
        ]);
    }
}
