<?php

namespace App\Questionnaire;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface Questionnairable
{
    public function createForm(string $type, $data = null, array $options = []): FormInterface;

    public function createAndHandleForm(string $type, Request $request, $data = null, array $options = []): FormInterface;

    public function submittedAndValid(FormInterface $form): bool;

    public function getFormBuilder(): FormFactoryInterface;
}
