<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exams_taken_count'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_student');
    }
}
