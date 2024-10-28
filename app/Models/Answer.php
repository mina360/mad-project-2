<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillabe = [
        'question_id',
        'choice',
        'answer',
        'is_correct',
    ];
}
