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

class AnswerController extends Controller
{
    public function __construct(protected AnswerService $answerService) {}

    public function store(AddAnswerRequest $request)
    {
        try {
            $this->authorize('create', Answer::class);
            $validatedData = $request->validated();

            $validatedData['is_correct'] = AnswerIsCorrect::fromBoolean($request->is_correct === 'true');

            // Create the answer
            $answer = $this->answerService->addAnswer($validatedData);

            return response()->json([
                'message' => 'Answer Created Successfully',
                'answer' => $answer
            ]);
        } catch (Exception $e) {
            throw new RuntimeException('Answer creation failed: ' . $e->getMessage());
        }
    }

    public function destroy(Answer $answer)
    {
        $this->authorize('delete', Answer::class);
        $deletedAnswer = $this->answerService->deleteAnswer($answer);
        return response()->json([
            'message' => 'Answer Deleted Successfully.',
            'deleted_answer' => $deletedAnswer
        ]);
    }
}
