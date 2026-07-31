<?php

declare(strict_types=1);

namespace App\Twig\Components\Form\Project;

use App\Controller\BaseController;
use App\Entity\Project\ProjectAdministrativeData;
use App\Entity\Project\ProjectSettings;
use App\Form\Project\ProjectSettingsType;
use App\Repository\Project\ProjectRepository;
use App\Service\Project\ProjectService;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class NewProjectForm extends BaseController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?ProjectAdministrativeData $initialFormData = null;

    public function __construct(
        private readonly ProjectRepository $projectRepository,
        private readonly ProjectService $projectService,
    ) {
    }

    #[LiveAction]
    public function save(): ?Response
    {
        $this->submitForm();
        /** @var ProjectSettings $settings */
        $settings = $this->getForm()->getData();

        $newProject = $this->projectService->createNewProject($this->getUser());
        $newProject->setSettings($settings);

        $this->projectRepository->save($newProject);

        return $this->redirectToRoute('Project-introduction', ['id' => $newProject->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(ProjectSettingsType::class, $this->initialFormData);
    }
}
