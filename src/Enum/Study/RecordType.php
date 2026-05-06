<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum RecordType: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case QUESTIONNAIRES = 'Questionnaires';
    case PAPER_PENCIL = 'Paper-pencil';
    case COMPUTER_SUPPORTED = 'Computer supported';
    case SPECIALIZED_APPARATUS = 'specialized apparatus';
    case OTHER = 'Other';

    public function label(): string
    {
        return match ($this) {
            self::QUESTIONNAIRES => 'record_type.questionnaires',
            self::PAPER_PENCIL => 'record_type.paper_pencil',
            self::COMPUTER_SUPPORTED => 'record_type.computer_supported',
            self::SPECIALIZED_APPARATUS => 'record_type.specialized_apparatus',
            self::OTHER => 'record_type.other',
        };
    }
}
