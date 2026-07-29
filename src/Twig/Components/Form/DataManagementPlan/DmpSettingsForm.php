<?php

namespace App\Twig\Components\Form\DataManagementPlan;

use App\Entity\DataManagementPlan\DmpSettings;
use App\Form\DataManagementPlan\DmpSettingsType;
use App\Repository\DataManagementPlan\DmpSettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class DmpSettingsForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?DmpSettings $initialFormData = null;

    public function __construct(
        private readonly DmpSettingsRepository $settingsRepository,
    ) {
    }

    #[LiveAction]
    public function save(): ?Response
    {
        $this->submitForm();
        /** @var DmpSettings $settings */
        $settings = $this->getForm()->getData();

        $this->settingsRepository->save($settings);

        return $this->redirectToRoute('Dmp-settings', ['id' => $settings->getDataManagementPlan()->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(DmpSettingsType::class, $this->initialFormData);
    }
}
