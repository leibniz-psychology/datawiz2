<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum CollectionMode: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case INDIVIDUAL_PRESENTATION = 'Individual Presentation';
    case GROUP_PRESENTATION = 'Group presentation';
    case PAPER_PENCIL = 'Paper-pencil';
    case RECORDINGS = 'Photo or video or audio Recordings';
    case COMPUTER_SUPPORT = 'Computer supported';
    case SPECIAL_APPARATUS = 'Special apparatus or measuring instruments';
    case TELEPHONE_SURVEY = 'Telephone survey';
    case POST_SURVEY = 'Post survey';
    case ONLINE_SURVEY = 'Online survey';
    case OTHER = 'Other';

    public function label(): string
    {
        return match ($this) {
            self::INDIVIDUAL_PRESENTATION => 'collection_mode.individual_presentation',
            self::GROUP_PRESENTATION => 'collection_mode.group_presentation',
            self::PAPER_PENCIL => 'collection_mode.paper_pencil',
            self::RECORDINGS => 'collection_mode.recordings',
            self::COMPUTER_SUPPORT => 'collection_mode.computer_support',
            self::SPECIAL_APPARATUS => 'collection_mode.special_apparatus',
            self::TELEPHONE_SURVEY => 'collection_mode.telephone_survey',
            self::POST_SURVEY => 'collection_mode.post_survey',
            self::ONLINE_SURVEY => 'collection_mode.online_survey',
            self::OTHER => 'collection_mode.other',
        };
    }
}
