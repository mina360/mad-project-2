<?php

namespace App\Enums;

enum ExamStatus: string
{
    case Scheduled = 'scheduled';
    case InProgress = 'in_progress';
    case Finished = 'finished';
    case Failed = 'failed';
    case Passed = 'passed';
}
