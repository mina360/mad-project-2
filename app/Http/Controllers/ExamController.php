<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExamRequest;
use App\Models\Exam;
use App\Services\ExamService;
use Exception;

class ExamController extends Controller
{

    public function __construct(protected ExamService $examService) {}

    public function add(CreateExamRequest $request)
    {
        $exam = $this->examService->createExam($request);

        return response()->json([
            'message' => 'Exam created successfully',
            'created exam' => $exam
        ]);
    }

    public function delete(Exam $exam)
    {
        if (!$exam) {
            throw new Exception('Exam not found.');
        }

        $exam = $this->examService->deleteExam($exam);

        return response()->json([
            'message' => 'Exam deleted successfully',
            'deleted exam' => $exam
        ]);
    }
}
