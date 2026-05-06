<?php

namespace App\Twig\Components\Form;

use App\Entity\Study\MeasureMetaDataGroup;
use App\Form\MeasureType;
use App\Repository\MeasureRepository;
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
class MeasureForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use DatawizFormTrait;
    public const string formType = 'measure';

    #[LiveProp]
    public ?MeasureMetaDataGroup $initialFormData = null;

    public function __construct(
        private readonly MeasureRepository $measureRepository,
    ) {
    }

    #[LiveAction]
    public function save(#[LiveArg] ?string $route): ?Response
    {
        $this->submitForm();
        /** @var MeasureMetaDataGroup $measure */
        $measure = $this->getForm()->getData();

        $this->measureRepository->save($measure);
        if (!is_null($route)) {
            return $this->redirectToRoute($route, [
                'id' => $measure->getExperiment()->getId(),
            ]);
        }

        return $this->redirectToRoute('Study-measure', ['id' => $measure->getExperiment()->getId()]);
    }

    #[LiveAction]
    public function addApparatus(): void
    {
        $this->formValues['apparatus'][] = [];
    }

    #[LiveAction]
    public function removeApparatus(#[LiveArg] int $index): void
    {
        unset($this->formValues['apparatus'][$index]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(MeasureType::class, $this->initialFormData);
    }
}
