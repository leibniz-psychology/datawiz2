<?php

namespace App\Questionnaire;

use phpDocumentor\Reflection\Types\Callable_;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class QuestionnaireService implements Questionnairable
{
    private $formBuilder;

    public function __construct(FormFactoryInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    public function createFormFromQuestionable(Questionable $entity): FormInterface {
        $form = $this->formBuilder->createBuilder(FormType::class, $entity);
        foreach ($entity::getDictionaryKeys() as $dictKey) {
            /** @var FormInstructionValue $instructions */
            $instructions = $entity::lookUpFormInstructions($dictKey);
            $form->add($dictKey, $instructions->getFormType(), $instructions->getFormOptions());
        }
        $form->add('save', SubmitType::class);
        return $form->getForm();
    }

    public function askAndHandle(Questionable $entity, Request $request, \Closure $onSuccessCallback): FormInterface {
        $form = $this->createFormFromQuestionable($entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $onSuccessCallback();
        }
        return $form;
    }
}
