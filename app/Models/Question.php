<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'exam_id',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function solves()
    {
        return $this->hasMany(Solve::class);
    }

    public function isValidAnswer($answer_id)
    {
        return $this->answers()->where('id', $answer_id)->exists();
    }
}
