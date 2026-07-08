<?php

namespace App\Twig\Components\Form;

use App\Entity\Study\BasicInformationMetaDataGroup;
use App\Entity\Study\CreatorMetaDataGroup;
use App\Form\BasicInformationType;
use App\Repository\BasicInformationRepository;
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
class BasicInformationForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use DatawizFormTrait;
    public const string formType = 'documentation';

    #[LiveProp]
    public ?BasicInformationMetaDataGroup $initialFormData = null;

    public function __construct(
        private readonly BasicInformationRepository $basicInformationRepository,
    ) {
    }

    #[LiveAction]
    public function save(#[LiveArg] ?string $route): ?Response
    {
        $this->submitForm();
        /** @var BasicInformationMetaDataGroup $basicInformation */
        $basicInformation = $this->getForm()->getData();

        $this->basicInformationRepository->save($basicInformation);
        if (!is_null($route)) {
            return $this->redirectToRoute($route, [
                'id' => $basicInformation->getExperiment()->getId(),
            ]);
        }

        return $this->redirectToRoute('Study-documentation', ['id' => $basicInformation->getExperiment()->getId()]);
    }

    #[LiveAction]
    public function addUsedSoftware(): void
    {
        $this->formValues['usedSoftwares'][] = [];
    }

    #[LiveAction]
    public function removeUsedSoftware(#[LiveArg] int $index): void
    {
        unset($this->formValues['usedSoftwares'][$index]);
    }

    #[LiveAction]
    public function addRelatedPublication(): void
    {
        $this->formValues['relatedPublications'][] = [];
    }

    #[LiveAction]
    public function removeRelatedPublication(#[LiveArg] int $index): void
    {
        unset($this->formValues['relatedPublications'][$index]);
    }

    #[LiveAction]
    public function addConflictOfInterest(): void
    {
        $this->formValues['conflictsOfInterest'][] = [];
    }

    #[LiveAction]
    public function removeConflictOfInterest(#[LiveArg] int $index): void
    {
        unset($this->formValues['conflictsOfInterest'][$index]);
    }

    #[LiveAction]
    public function addCreator(): void
    {
        $this->formValues['creators'][] = [];
    }

    #[LiveAction]
    public function removeCreator(#[LiveArg] int $index): void
    {
        unset($this->formValues['creators'][$index]);
        $this->formValues['creators'] = array_values($this->formValues['creators']);
    }

    protected function instantiateForm(): FormInterface
    {
        if ($this->initialFormData->getUsedSoftwares() == [] or $this->initialFormData->getUsedSoftwares() == null) {
            $this->initialFormData->setUsedSoftwares(['']);
        }
        if ($this->initialFormData->getRelatedPublications() == [] or $this->initialFormData->getRelatedPublications() == null) {
            $this->initialFormData->setRelatedPublications(['']);
        }
        if ($this->initialFormData->getConflictsOfInterest() == [] or $this->initialFormData->getConflictsOfInterest() == null) {
            $this->initialFormData->setConflictsOfInterest(['']);
        }
        if ($this->initialFormData->getCreators()->isEmpty()) {
            $this->initialFormData->addCreator(new CreatorMetaDataGroup());
        }

        return $this->createForm(BasicInformationType::class, $this->initialFormData);
    }
}
