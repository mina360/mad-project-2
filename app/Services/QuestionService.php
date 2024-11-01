<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use RuntimeException;
use Exception;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionService
{

    public function __construct(protected ExamService $examService) {}
    public function addQuestion(array $data): Question
    {
        return DB::transaction(function () use ($data) {
            $availability = $this->examService->checkExamsQuestions($data['exam_id']);
            $question = Question::create($data);
            Log::info("question received", [$question]);

            if (!$question) {
                throw new RuntimeException('question creation failed');
            }

            return $question;
        });
    }

    public function deleteQuestion(Question $question)
    {
        $question->delete();

        return $question;
    }
}
