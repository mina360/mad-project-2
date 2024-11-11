<?php

namespace App\Models;

use App\Enums\AnswerIsCorrect;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer',
        'is_correct',
        'question_id',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }


    public function solves()
    {
        return $this->hasMany(Solve::class);
    }

    protected $casts = [
        'is_correct' => AnswerIsCorrect::class,
    ];

}
