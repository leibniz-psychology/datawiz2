<?php


namespace App\Questionnaire;


use App\Domain\Definition\MetaDataValuable;

interface Questionable
{
    public static function getDictionaryKeys(): array;
    public static function lookUpFormInstructions(string $metadatadictionaryEntry): ?FormInstructionValue;
}