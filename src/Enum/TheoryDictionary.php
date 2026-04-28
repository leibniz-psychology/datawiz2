<?php

namespace App\Enum;

enum TheoryDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case OBJECTIVES = 'objectives';
    case HYPOTHESES = 'hypotheses';
    case THEORIES = 'theories';

    public function legend(): string
    {
        return match ($this) {
            self::OBJECTIVES => 'theory_meta_data_group.objectives.legend',
            self::HYPOTHESES => 'theory_meta_data_group.hypotheses.legend',
            self::THEORIES => 'theory_meta_data_group.theories.legend',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::OBJECTIVES => 'theory_meta_data_group.objectives.label',
            self::HYPOTHESES => 'theory_meta_data_group.hypotheses.label',
            self::THEORIES => 'theory_meta_data_group.theories.label',
        };
    }

    public function descriptionHelp(): string
    {
        return match ($this) {
            self::OBJECTIVES => 'theory.objectives',
            self::HYPOTHESES => 'theory.hypotheses',
            self::THEORIES => 'theory.theories',
        };
    }
}
