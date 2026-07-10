<?php

namespace App\Twig\Components\Form\Study;

use App\Controller\BaseController;
use App\Entity\Study\SettingsMetaDataGroup;
use App\Form\Study\SettingsType;
use App\Repository\Study\ExperimentRepository;
use App\Service\Study\ExperimentService;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class NewExperimentForm extends BaseController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?SettingsMetaDataGroup $initialFormData = null;

    public function __construct(
        private readonly ExperimentRepository $experimentRepository,
        private readonly ExperimentService $experimentService,
    ) {
    }

    #[LiveAction]
    public function save(): ?Response
    {
        $this->submitForm();
        /** @var SettingsMetaDataGroup $settings */
        $settings = $this->getForm()->getData();

        $newExperiment = $this->experimentService->createNewExperiment($this->getUser());
        $newExperiment->setSettingsMetaDataGroup($settings);

        $this->experimentRepository->save($newExperiment);

        return $this->redirectToRoute('Study-introduction', ['id' => $newExperiment->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(SettingsType::class, $this->initialFormData);
    }
}
