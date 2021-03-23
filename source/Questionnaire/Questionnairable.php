<?php

namespace App\Questionnaire;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface Questionnairable
{
    public function askAndHandle(Questionable $entity, Request $request, \Closure $onSuccessCallback): ?FormInterface;
}
