<?php

namespace App\Service\Questionnaire;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

readonly class QuestionnaireService implements Questionnairable
{
    public function __construct(
        private FormFactoryInterface $formBuilder
    ) {}

    public function formFromEntity(Questionable $entity, string $buttonLabel): ?FormInterface
    {
        $form = $this->formBuilder->createBuilder($entity->getFormTypeForEntity(), $entity);
        $form->add('submit', SubmitType::class, ['label' => $buttonLabel]);

        return $form->getForm();
    }

    public function formFromClass(string $class, Questionable $entity, string $buttonLabel): ?FormInterface
    {
        $form = $this->formBuilder->createBuilder($class, $entity);
        $form->add('submit', SubmitType::class, ['label' => $buttonLabel]);

        return $form->getForm();
    }

    public function askAndHandle(Questionable $entity, string $buttonLabel, Request $request): ?FormInterface
    {
        $form = $this->formFromEntity($entity, $buttonLabel);
        $form->handleRequest($request);

        return $form;
    }

    public function isSubmittedAndValid(FormInterface $form): bool
    {
        return $form->isSubmitted() && $form->isValid();
    }
}
