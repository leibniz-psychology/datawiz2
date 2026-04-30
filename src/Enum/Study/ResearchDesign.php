<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum ResearchDesign: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case CROSS_SECTIONAL = 'Cross-sectional';
    case LONGITUDINAL = 'Longitudinal';

    public function label(): string
    {
        return match ($this) {
            self::CROSS_SECTIONAL => 'research_design.cross_sectional',
            self::LONGITUDINAL => 'research_design.longitudinal',
        };
    }

    public function labelExtended(): string
    {
        return match ($this) {
            self::CROSS_SECTIONAL => 'research_design.extended.cross_sectional',
            self::LONGITUDINAL => 'research_design.extended.longitudinal',
        };
    }
}
