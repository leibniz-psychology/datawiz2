<?php

namespace App\Enum;

enum ControlOperations: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case NONE = 'None';
    case BLOCK_RANDOMIZATION = 'Block randomization';
    case COMPLETE_COUNTERBALANCING = 'Complete counterbalancing (all possible orders)';
    case INCOMPLETE_COUNTERBALANCING = 'Incomplete counterbalancing (partial counterbalancing)';
    case LATIN_SQUARE = 'Latin Square';
    case LATIN_SQUARE_RNG = 'Latin Square using a random starting order with rotation (rotate order)';
    case REVERSE_COUNTERBALANCING = 'Reverse counterbalancing (ABBA-counterbalancing)';
    case OTHER = 'Other';

    public function label(): string
    {
        return match ($this) {
            self::NONE => 'control_operations.none',
            self::BLOCK_RANDOMIZATION => 'control_operations.block_randomization',
            self::COMPLETE_COUNTERBALANCING => 'control_operations.complete_counterbalancing',
            self::INCOMPLETE_COUNTERBALANCING => 'control_operations.incomplete_counterbalancing',
            self::LATIN_SQUARE => 'control_operations.latin_square',
            self::LATIN_SQUARE_RNG => 'control_operations.latin_square_rng',
            self::REVERSE_COUNTERBALANCING => 'control_operations.reverse_counterbalancing',
            self::OTHER => 'control_operations.other',
        };
    }
}
