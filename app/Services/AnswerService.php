<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use RuntimeException;
use Exception;
use App\Models\Answer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnswerService
{

    public function addAnswer(array $data): Answer
    {
        return DB::transaction(function () use ($data) {

            $answer = Answer::create($data);

            if (!$answer) {
                throw new RuntimeException('Answer creation failed');
            }
            return $answer;
        });
    }
}
