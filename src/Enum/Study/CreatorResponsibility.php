<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum CreatorResponsibility: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case PRINCIPAL_INVESTIGATOR = 'Principal investigator';
    case SCIENTIFIC_CONTRIBUTION = 'Scientific contribution';
    case DATA_COLLECTION = 'Data Collection';
    case DATA_PROCESSING = 'Data processing';
    case OTHER = 'OTHER';

    public function label(): string
    {
        return match ($this) {
            self::PRINCIPAL_INVESTIGATOR => 'creator_responsibility.principal_investigator',
            self::SCIENTIFIC_CONTRIBUTION => 'creator_responsibility.scientific_contribution',
            self::DATA_COLLECTION => 'creator_responsibility.data_collection',
            self::DATA_PROCESSING => 'creator_responsibility.data_processing',
            self::OTHER => 'creator_responsibility.other',
        };
    }
}
