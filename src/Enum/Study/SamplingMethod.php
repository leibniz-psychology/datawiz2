<?php

namespace App\Enum\Study;

use App\Enum\ExtendedEnum;
use App\Enum\ExtendedEnumInterface;

enum SamplingMethod: string implements ExtendedEnumInterface
{
    use ExtendedEnum;

    case CONVENIANCE = 'Convenience sample';
    case CENSUS = 'Census';
    case SIMPLE_RANDOM = 'Simple random sample';
    case CLUSTER = 'Cluster sample';
    case STRATIFIED = 'Stratified systematic sample';
    case QUOTA = 'Quota sample';
    case OTHER = 'Other';

    public function label(): string
    {
        return match ($this) {
            self::CONVENIANCE => 'sampling_method.convenience',
            self::CENSUS => 'sampling_method.census',
            self::SIMPLE_RANDOM => 'sampling_method.simple_random',
            self::CLUSTER => 'sampling_method.cluster',
            self::STRATIFIED => 'sampling_method.stratified',
            self::QUOTA => 'sampling_method.quota',
            self::OTHER => 'sampling_method.other',
        };
    }
}
