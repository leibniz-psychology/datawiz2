<?php

namespace App\Twig\Components\Form\Study;

use App\Entity\Study\SettingsMetaDataGroup;
use App\Form\Study\SettingsType;
use App\Repository\Study\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class SettingsForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?SettingsMetaDataGroup $initialFormData = null;

    public function __construct(
        private readonly SettingsRepository $settingsRepository,
    ) {
    }

    #[LiveAction]
    public function save(): ?Response
    {
        $this->submitForm();
        /** @var SettingsMetaDataGroup $settings */
        $settings = $this->getForm()->getData();

        $this->settingsRepository->save($settings);

        return $this->redirectToRoute('Study-settings', ['id' => $settings->getExperiment()->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(SettingsType::class, $this->initialFormData);
    }
}
