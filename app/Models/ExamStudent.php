<?php

namespace App\Models;

use App\Enums\ExamStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamStudent extends Model
{
    use HasFactory;

    protected $fillabe = [
        'exam_id',
        'student_id',
        'score',
        'status',
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
}
