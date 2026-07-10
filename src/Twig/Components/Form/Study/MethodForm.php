<?php

namespace App\Twig\Components\Form\Study;

use App\Entity\Study\MeasurementInstrument;
use App\Entity\Study\MeasurementOccasion;
use App\Entity\Study\MethodConstruct;
use App\Entity\Study\MethodMetaDataGroup;
use App\Form\Study\MethodType;
use App\Repository\Study\MethodRepository;
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
class MethodForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use StudyFormTrait;
    public const string formType = 'method';

    #[LiveProp]
    public ?MethodMetaDataGroup $initialFormData = null;

    public function __construct(
        private readonly MethodRepository $methodRepository,
    ) {
    }

    #[LiveAction]
    public function save(#[LiveArg] ?string $route): ?Response
    {
        $this->submitForm();
        /** @var MethodMetaDataGroup $method */
        $method = $this->getForm()->getData();

        foreach ($method->getMeasurementOccasions() as $key => $measurementOccasion) {
            $measurementOccasion->setPosition($key + 1);
        }

        $this->methodRepository->save($method);
        if (!is_null($route)) {
            return $this->redirectToRoute($route, [
                'id' => $method->getExperiment()->getId(),
            ]);
        }

        return $this->redirectToRoute('Study-method', ['id' => $method->getExperiment()->getId()]);
    }

    #[LiveAction]
    public function addTreatmentGroup(): void
    {
        $this->formValues['treatmentGroups'][] = [];
    }

    #[LiveAction]
    public function removeTreatmentGroup(#[LiveArg] int $index): void
    {
        unset($this->formValues['treatmentGroups'][$index]);
    }

    #[LiveAction]
    public function addMeasurementOccasion(): void
    {
        $this->formValues['measurementOccasions'][] = [];
    }

    #[LiveAction]
    public function removeMeasurementOccasion(#[LiveArg] int $index): void
    {
        unset($this->formValues['measurementOccasions'][$index]);
        $this->formValues['measurementOccasions'] = array_values($this->formValues['measurementOccasions']);
    }

    #[LiveAction]
    public function addConstruct(): void
    {
        $this->formValues['constructs'][] = [];
    }

    #[LiveAction]
    public function removeConstruct(#[LiveArg] int $index): void
    {
        unset($this->formValues['constructs'][$index]);
        $this->formValues['constructs'] = array_values($this->formValues['constructs']);
    }

    #[LiveAction]
    public function addMeasurementInstrument(): void
    {
        $this->formValues['measurementInstruments'][] = [];
    }

    #[LiveAction]
    public function removeMeasurementInstrument(#[LiveArg] int $index): void
    {
        unset($this->formValues['measurementInstruments'][$index]);
        $this->formValues['measurementInstruments'] = array_values($this->formValues['measurementInstruments']);
    }

    protected function instantiateForm(): FormInterface
    {
        if ($this->initialFormData->getMeasurementOccasions()->isEmpty()) {
            $this->initialFormData->addMeasurementOccasion(new MeasurementOccasion());
        }
        if ($this->initialFormData->getConstructs()->isEmpty()) {
            $this->initialFormData->addConstruct(new MethodConstruct());
        }
        if ($this->initialFormData->getMeasurementInstruments()->isEmpty()) {
            $this->initialFormData->addMeasurementInstrument(new MeasurementInstrument());
        }
        if ($this->initialFormData->getTreatmentGroups() == [] or $this->initialFormData->getTreatmentGroups() == null) {
            $this->initialFormData->setTreatmentGroups(['']);
        }

        return $this->createForm(MethodType::class, $this->initialFormData);
    }
}
