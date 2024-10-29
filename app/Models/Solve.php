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
        'attempt'
    ];
}
