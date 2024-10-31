<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddQuestionsRequest;
use App\Services\QuestionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RuntimeException;
use Exception;
use App\Models\Question;
use Illuminate\Support\Facades\Log;

class QuestionsController extends Controller
{
    //
    public function __construct(protected QuestionService $questionService) {}

    public function store(AddQuestionsRequest $request)
    {
        try {
            if (Auth::user()->role != 'teacher') {
                throw new Exception("Not Authorized", 401);
            }

            $question = $this->questionService->addQuestion($request->validated());

            return response()->json([
                'message' => 'Question Created Successfully',
                'question' => $question
            ]);
        } catch (Exception $e) {
            throw new RuntimeException('question creation failed');
        }
    }

    public function destroy(Question $question)
    {
        if (Auth::user()->role != 'teacher') {
            throw new Exception("Not Authorized", 401);
        }
        $deleteQuestion = $this->questionService->deleteQuestion($question);
        return response()->json([
            'message' => 'Question Deleted Successfully.',
            'Deleted Question' => $deleteQuestion
        ]);
    }
}
