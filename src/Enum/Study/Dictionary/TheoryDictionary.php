<?php

namespace App\Enum\Study\Dictionary;

use App\Entity\Dto\ReviewDataDto;
use App\Enum\DictionaryEnum;
use App\Enum\DictionaryInterface;
use App\Enum\ErrorType;
use App\Enum\ExtendedEnum;

enum TheoryDictionary: string implements DictionaryInterface
{
    use ExtendedEnum;
    use DictionaryEnum;

    case OBJECTIVES = 'objectives';
    case HYPOTHESES = 'hypotheses';
    case EXPLORATORY_RESEARCH_QUESTIONS = 'exploratoryResearchQuestions';
    case THEORIES = 'theories';

    public function legend(): string
    {
        return match ($this) {
            self::OBJECTIVES => 'theory_meta_data_group.objectives.legend',
            self::HYPOTHESES => 'theory_meta_data_group.hypotheses.legend',
            self::EXPLORATORY_RESEARCH_QUESTIONS => 'theory_meta_data_group.exploratory_research_questions.legend',
            self::THEORIES => 'theory_meta_data_group.theories.legend',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::OBJECTIVES => 'theory_meta_data_group.objectives.label',
            self::HYPOTHESES => 'theory_meta_data_group.hypotheses.label',
            self::EXPLORATORY_RESEARCH_QUESTIONS => 'theory_meta_data_group.exploratory_research_questions.label',
            self::THEORIES => 'theory_meta_data_group.theories.label',
        };
    }

    public function descriptionHelp(): string
    {
        return match ($this) {
            self::OBJECTIVES => 'theory.objectives',
            self::HYPOTHESES => 'theory.hypotheses',
            self::EXPLORATORY_RESEARCH_QUESTIONS => 'theory.exploratory_research_questions',
            self::THEORIES => 'theory.theories',
        };
    }

    public function reviewData(): ReviewDataDto
    {
        return match ($this) {
            self::OBJECTIVES => new ReviewDataDto('theory_meta_data_group.objectives.error_message', ErrorType::MANDATORY),
            self::HYPOTHESES => new ReviewDataDto('theory_meta_data_group.hypotheses.error_message', ErrorType::MANDATORY),
            self::EXPLORATORY_RESEARCH_QUESTIONS => new ReviewDataDto('theory_meta_data_group.exploratory_research_questions.error_message', ErrorType::OPTIONAL),
            self::THEORIES => new ReviewDataDto('theory_meta_data_group.theories.error_message', ErrorType::MANDATORY),
        };
    }
}
