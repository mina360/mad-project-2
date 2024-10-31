<?php

namespace App\Enums;

enum AnswerIsCorrect: int
{
    case true = 1;
    case false = 0;

    public static function fromBoolean(bool $value): self
    {
        return $value ? self::true : self::false;
    }
}
