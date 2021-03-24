<?php

namespace App\Questionnaire;

interface Questionable
{
    public function getFormTypeForEntity(): string;
}
