<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solve extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_student_id',
        'question_id',
        'answer_id',
    ];

    public function examStudent()
    {
        return $this->belongsTo(ExamStudent::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function countAnswers($exam_student_id)
    {
        return $this->where('exam_student_id', $exam_student_id)->count();
    }
}
