<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'teacher_id',
        'num_of_questions'
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'exam_student');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function isValidQuestion($question_id)
    {
        return $this->questions()->where('id', $question_id)->exists();
    }
}
