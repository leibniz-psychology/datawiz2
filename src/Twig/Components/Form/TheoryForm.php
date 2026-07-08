<?php

namespace App\Twig\Components\Form;

use App\Entity\Study\TheoryMetaDataGroup;
use App\Form\TheoryType;
use App\Repository\TheoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class TheoryForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use DatawizFormTrait;
    public const string formType = 'theory';

    #[LiveProp]
    public ?TheoryMetaDataGroup $initialFormData = null;

    public function __construct(
        private readonly TheoryRepository $theoryRepository,
    ) {
    }

    #[LiveAction]
    public function save(#[LiveArg] ?string $route): ?Response
    {
        $this->submitForm();
        /** @var TheoryMetaDataGroup $theory */
        $theory = $this->getForm()->getData();

        $this->theoryRepository->save($theory);
        if (!is_null($route)) {
            return $this->redirectToRoute($route, [
                'id' => $theory->getExperiment()->getId(),
            ]);
        }

        return $this->redirectToRoute('Study-theory', ['id' => $theory->getExperiment()->getId()]);
    }

    #[LiveAction]
    public function addObjective(): void
    {
        $this->formValues['objectives'][] = [];
    }

    #[LiveAction]
    public function removeObjective(#[LiveArg] int $index): void
    {
        unset($this->formValues['objectives'][$index]);
    }

    #[LiveAction]
    public function addHypothesis(): void
    {
        $this->formValues['hypotheses'][] = [];
    }

    #[LiveAction]
    public function removeHypothesis(#[LiveArg] int $index): void
    {
        unset($this->formValues['hypotheses'][$index]);
    }

    #[LiveAction]
    public function addExploratoryResearchQuestion(): void
    {
        $this->formValues['exploratoryResearchQuestions'][] = [];
    }

    #[LiveAction]
    public function removeExploratoryResearchQuestion(#[LiveArg] int $index): void
    {
        unset($this->formValues['exploratoryResearchQuestions'][$index]);
    }

    #[LiveAction]
    public function addTheory(): void
    {
        $this->formValues['theories'][] = [];
    }

    #[LiveAction]
    public function removeTheory(#[LiveArg] int $index): void
    {
        unset($this->formValues['theories'][$index]);
    }

    protected function instantiateForm(): FormInterface
    {
        if ($this->initialFormData->getObjectives() == [] or $this->initialFormData->getObjectives() == null) {
            $this->initialFormData->setObjectives(['']);
        }
        if ($this->initialFormData->getHypotheses() == [] or $this->initialFormData->getHypotheses() == null) {
            $this->initialFormData->setHypotheses(['']);
        }
        if ($this->initialFormData->getExploratoryResearchQuestions() == [] or $this->initialFormData->getExploratoryResearchQuestions() == null) {
            $this->initialFormData->setExploratoryResearchQuestions(['']);
        }
        if ($this->initialFormData->getTheories() == [] or $this->initialFormData->getTheories() == null) {
            $this->initialFormData->setTheories(['']);
        }
        return $this->createForm(TheoryType::class, $this->initialFormData);
    }
}
