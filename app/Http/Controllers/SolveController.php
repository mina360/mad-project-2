<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Answer;
use App\Models\Question;
use App\Enums\ExamStatus;
use App\Models\ExamStudent;
use App\Services\SolveService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SolveRequest;
use App\Services\ExamStudentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SolveController extends Controller
{
    protected $solveService;
    protected $examStudentService;
    public function __construct(SolveService $solveService, ExamStudentService $examStudentService)
    {
        $this->solveService = $solveService;
        $this->examStudentService = $examStudentService;
    }

    public function takeExam($exam_id)
    {
        if (Gate::denies('isStudent')) {
            throw new Exception("You are not allowed to take exams.");
        }
        $exam_student = $this->examStudentService->createExamStudent($exam_id);
        return response()->json([
            'Exam Student' => $exam_student
        ]);
    }
    public function getExam($exam_id)
    {
        $user_id = Auth::id();
        $exam_student = ExamStudent::where([
            'exam_id' => $exam_id,
            'student_id' => $user_id,
        ])->first();
        if (!$exam_student) {
            throw new Exception("ExamStudent not found.");
        }
        if ($exam_student->status != ExamStatus::InProgress) {
            throw new Exception("You finished exam or you didn't start it.");
        }
        return $exam_student;
    }
    public function addSolve(SolveRequest $request, $exam_id)
    {
        if (Gate::denies('isStudent')) {
            throw new Exception("You are not allowed to take exams.");
        }
        if (Gate::denies('isExamStudentOwner')) {
            throw new Exception("You are not allowed to take this exam.");
        }
        $exam_student = $this->getExam($exam_id);
        $exam = Exam::find($exam_id);
        $question = Question::find($request['question_id']);
        $student_answer = Answer::find($request['answer_id']);
        if (! $exam->isValidQuestion($question->id)) {
            throw new Exception("Invalid question");
        }
        if (! $question->isValidAnswer($student_answer->id)) {
            throw new Exception("Invalid answer");
        }
        $solve = null;
        DB::transaction(function () use ($exam_student, $student_answer, $request, &$solve) {
            $solve = $this->solveService->createSolve($request, $exam_student);
            if ($student_answer->is_correct) {
                $exam_student->incrementCorrectAnswersCount();
            }
        });
        return response()->json([
            'message' => 'Your solve was saved',
            'your solve' => $solve,
        ]);
    }
    public function calculateScore($exam_student_id)
    {
        $exam_student = ExamStudent::findOrFail($exam_student_id);
        $this->authorize('viewResult', $exam_student);
        if (! $this->checkExamIfFinished($exam_student)) {
            throw new Exception("You can't calculate your score until you solve all the questions in this exam.");
        }
        $exam_student->updateScore($exam_student->correct_answers_count);
        $result = $exam_student->getExamResult();
        return response()->json([
            'score' => $exam_student->score,
            'exam status' => $result
        ]);
    }
    public function checkExamIfFinished($exam_student_id)
    {
        $exam_student = ExamStudent::find($exam_student_id);
        if ($exam_student->solves()->count() != 100) {
            return False;
        }
        $exam_student->status = ExamStatus::Finished;
        $exam_student->save();
        return true;
    }
}
