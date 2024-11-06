<?php

namespace App\Enums;

enum ExamStatus: string
{
    case Scheduled = 'scheduled';
    case InProgress = 'in_progress';
    case Failed = 'failed';
    case Passed = 'passed';
}
