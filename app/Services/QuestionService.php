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
            $this->examService->checkExamsQuestions($data['exam_id']);
            $question = Question::create($data);

            if (!$question) {
                throw new RuntimeException('question creation failed');
            }

            return $question;
        });
    }
}
