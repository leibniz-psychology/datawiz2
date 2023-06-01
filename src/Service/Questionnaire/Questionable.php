<?php

namespace App\Service\Questionnaire;

interface Questionable
{
    public function getFormTypeForEntity(): string;
}
