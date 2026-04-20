<?php

namespace App\Twig\Components\Form;

use App\Entity\Study\SampleMetaDataGroup;
use App\Form\SampleType;
use App\Repository\SampleRepository;
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
class SampleForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use DatawizFormTrait;
    public const string formType = 'sample';

    #[LiveProp]
    public ?SampleMetaDataGroup $initialFormData = null;

    public function __construct(
        private readonly SampleRepository $sampleRepository,
    ) {
    }

    #[LiveAction]
    public function save(#[LiveArg] ?string $route): ?Response
    {
        $this->submitForm();
        /** @var SampleMetaDataGroup $sample */
        $sample = $this->getForm()->getData();

        $this->sampleRepository->save($sample);
        if (!is_null($route)) {
            return $this->redirectToRoute($route, [
                'id' => $sample->getExperiment()->getId(),
            ]);
        }

        return $this->redirectToRoute('Study-sample', ['id' => $sample->getExperiment()->getId()]);
    }

    #[LiveAction]
    public function addPopulation(): void
    {
        $this->formValues['population'][] = [];
    }

    #[LiveAction]
    public function removePopulation(#[LiveArg] int $index): void
    {
        unset($this->formValues['population'][$index]);
    }

    #[LiveAction]
    public function addInclusion(): void
    {
        $this->formValues['inclusion_criteria'][] = [];
    }

    #[LiveAction]
    public function removeInclusion(#[LiveArg] int $index): void
    {
        unset($this->formValues['inclusion_criteria'][$index]);
    }

    #[LiveAction]
    public function addExclusion(): void
    {
        $this->formValues['exclusion_criteria'][] = [];
    }

    #[LiveAction]
    public function removeExclusion(#[LiveArg] int $index): void
    {
        unset($this->formValues['exclusion_criteria'][$index]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(SampleType::class, $this->initialFormData);
    }
}
