<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\AnswerIsCorrect;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddAnswerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use RuntimeException;
use App\Models\Answer;
use App\Services\AnswerService;
use Illuminate\Support\Facades\Log;

class AnswerController extends Controller
{
    public function __construct(protected AnswerService $answerService) {}

    public function store(AddAnswerRequest $request)
    {
        try {
            $this->authorize('create', Answer::class);
            $answer = $this->answerService->addAnswer($request->validated());

            return response()->json([
                'message' => 'Answer Created Successfully',
                'answer' => $answer
            ], 201);
        } catch (Exception $e) {
            Log::error('Answer creation failed: ' . $e->getMessage());
            return response()->json([
                'message' => 'Answer creation failed: ' . $e->getMessage()
            ], 500);
        }
    }


    public function destroy(Answer $answer)
    {
        $this->authorize('delete', Answer::class);
        $deletedAnswer = $answer->delete();
        return response()->json([
            'message' => 'Answer Deleted Successfully.',
            'deleted_answer' => $deletedAnswer
        ]);
    }
}
