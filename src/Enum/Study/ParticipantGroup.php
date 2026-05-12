<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum ParticipantGroup: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case HEALTHY = 'Healthy individuals';
    case PHYSICAL_ILLNESS = 'Physical illness';
    case MENTAL_ILLNESS = 'Mental illness';
    case IN_TREATMENT = 'In treatment';
    case INSTITUTIONALIZED = 'Institutionalized';
    case INCAPABLE_OF_GIVING_CONSENT = 'Incapable of giving consent';
    case VULNERABLE_SITUATION = 'Vulnerable situation';
    case DEPENDENT_RELATIONSHIP = 'Dependent relationship';
    case OTHER = 'Other';

    public function label(): string
    {
        return match ($this) {
            self::HEALTHY => 'participant_group.healthy',
            self::PHYSICAL_ILLNESS => 'participant_group.physical_illness',
            self::MENTAL_ILLNESS => 'participant_group.mental_illness',
            self::IN_TREATMENT => 'participant_group.in_treatment',
            self::INSTITUTIONALIZED => 'participant_group.institutionalized',
            self::INCAPABLE_OF_GIVING_CONSENT => 'participant_group.incapable_of_giving_consent',
            self::VULNERABLE_SITUATION => 'participant_group.vulnerable_situation',
            self::DEPENDENT_RELATIONSHIP => 'participant_group.dependent_relationship',
            self::OTHER => 'participant_group.other',
        };
    }

    public function labelExtended(): string
    {
        return match ($this) {
            self::MENTAL_ILLNESS => 'participant_group.extended.mental_illness',
            self::INSTITUTIONALIZED => 'participant_group.extended.institutionalized',
            self::INCAPABLE_OF_GIVING_CONSENT => 'participant_group.extended.incapable_of_giving_consent',
            self::VULNERABLE_SITUATION => 'participant_group.extended.vulnerable_situation',
            self::DEPENDENT_RELATIONSHIP => 'participant_group.extended.dependent_relationship',
            default => $this->label(),
        };
    }
}
