<?php


namespace App\Questionnaire;


interface Questionable
{
    public static function provideFormConfigurationFor(string $metadatadictionaryEntry): ?array;

    public static function provideAllFormConfigurations(): array;
}