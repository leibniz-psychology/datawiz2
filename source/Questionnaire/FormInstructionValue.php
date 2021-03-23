<?php


namespace App\Questionnaire;


final class FormInstructionValue
{
    private $formType;
    private $formOptions;

    public function __construct(string $formType, array $formOptions)
    {
           $this->formType = $formType;
           $this->formOptions = $formOptions;
    }

    public function getFormOptions(): array
    {
        return $this->formOptions;
    }

    public function getFormType(): string
    {
        return $this->formType;
    }
}