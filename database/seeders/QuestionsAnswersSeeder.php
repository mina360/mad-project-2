<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Answer;

class QuestionsAnswersSeeder extends Seeder
{
    public function run()
    {
        Question::factory(100)->create()->each(function ($question) {
            Answer::factory(3)->create([
                'question_id' => $question->id,
                'is_correct' => false,
            ]);

            Answer::factory()->create([
                'question_id' => $question->id,
                'is_correct' => true,
            ]);
        });
    }
}
