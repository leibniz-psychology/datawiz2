<?php

declare(strict_types=1);

namespace App\Twig\Components\Form\Project;

use App\Entity\Project\ProjectSettings;
use App\Form\Project\ProjectSettingsType;
use App\Repository\Project\ProjectSettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class ProjectSettingsForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?ProjectSettings $initialFormData = null;

    public function __construct(
        private readonly ProjectSettingsRepository $settingsRepository,
    ) {
    }

    #[LiveAction]
    public function save(): ?Response
    {
        $this->submitForm();
        /** @var ProjectSettings $settings */
        $settings = $this->getForm()->getData();

        $this->settingsRepository->save($settings);

        return $this->redirectToRoute('Project-settings', ['id' => $settings->getProject()->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(ProjectSettingsType::class, $this->initialFormData);
    }
}
