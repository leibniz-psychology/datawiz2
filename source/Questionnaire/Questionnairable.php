<?php

namespace App\Questionnaire;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface Questionnairable
{
    public function formFromEntity(Questionable $entity, string $buttonLabel): ?FormInterface;

    public function askAndHandle(Questionable $entity, string $buttonLabel, Request $request): ?FormInterface;

    public function isSubmittedAndValid(FormInterface $form): bool;
}
