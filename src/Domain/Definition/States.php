<?php

namespace App\Domain\Definition;

class States
{
    public const STATE_STUDY_NONE = 0b00000000;
    public const STATE_STUDY_WITHDRAWN = 0b00000001;
    public const STATE_STUDY_SUBMITTED = 0b00000010;
    public const STATE_STUDY_PENDING = 0b00000011;
    public const STATE_STUDY_ACCEPTED = 0b00000100;


    public static function findByName(string $name)
    {
        return constant('self::'.$name);
    }
}