<?php

namespace App\Domain\Definition;

class States
{
    final public const STATE_STUDY_NONE = 0b00000000;
    final public const STATE_STUDY_WITHDRAWN = 0b00000001;
    final public const STATE_STUDY_SUBMITTED = 0b00000010;
    final public const STATE_STUDY_PENDING = 0b00000011;
    final public const STATE_STUDY_ACCEPTED = 0b00000100;


    public static function findByName(string $name)
    {
        return constant('self::'.$name);
    }
}