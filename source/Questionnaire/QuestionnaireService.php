<?php

namespace App\Questionnaire;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class QuestionnaireService implements Questionable
{
    private $formBuilder;

    public function __construct(FormFactoryInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    /**
     * Wrapper function to create a new form with the FormBuilder service.
     */
    public function createForm(string $type, $data = null, array $options = []): FormInterface
    {
        return $this->formBuilder->create($type, $data, $options);
    }

    /**
     * Create a new form and handle it in one call.
     */
    public function createAndHandleForm(string $type, Request $request, $data = null, array $options = []): FormInterface
    {
        return $this->formBuilder->create($type, $data, $options)->handleRequest($request);
    }

    /**
     * Wrapper function to check if a form was submitted and valid.
     */
    public function submittedAndValid(FormInterface $formToHandle): bool
    {
        return $formToHandle->isSubmitted() && $formToHandle->isValid();
    }

    /**
     * Return formbuilder for free actions
     */
    public function getFormBuilder(): FormFactoryInterface {
        return $this->formBuilder;
    }
}
