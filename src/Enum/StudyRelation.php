<?php

namespace App\Enum;

enum StudyRelation: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case REPLICATION = 'replication';
    case FOLLOW_UP = 'follow up';
    case NO_RELATION = 'no relation';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::REPLICATION => 'study_relation.replication',
            self::FOLLOW_UP => 'study_relation.follow_up',
            self::OTHER => 'study_relation.other',
            self::NO_RELATION => 'study_relation.no_relation',
        };
    }
}
