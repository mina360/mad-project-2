<?php

namespace App\Models;

use App\Enums\ExamStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',
        'score',
        'status',
        'attempt',
        'attempted_at',
        'correct_answers_count'
    ];

    protected $casts = [
        'status' => ExamStatus::class,
    ];

    public function solves()
    {
        return $this->hasMany(Solve::class);
    }

    public function updateScore($score)
    {
        return $this->score = $score;
    }

    public function incrementAttempt()
    {
        if (now() > $this->attempted_at->addMonths(6) && $this->attempt < 3) {
            $this->increment('attempt');
            $this->attempted_at = now();
        }
        return $this;
    }
    public function incrementCorrectAnswersCount()
    {
        return $this->increment('correct_answers_count');
    }
    public function updateExamStatus()
    {
        return $this->correct_answers_count >= 60 ? ExamStatus::Passed : ExamStatus::Failed;
    }
}
