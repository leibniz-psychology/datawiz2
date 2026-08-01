<?php

declare(strict_types=1);

namespace App\Twig\Components\Form\Project;

use App\Entity\DataManagementPlan\DataManagementPlan;
use App\Entity\Project\Project;
use App\Form\Project\ProjectDataManagementPlansType;
use App\Service\Project\ProjectService;
use Doctrine\ORM\EntityManagerInterface;
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
class ProjectDataManagementPlansForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use ProjectFormTrait;

    public const string formType = 'dataManagementPlans';

    #[LiveProp]
    public ?Project $initialFormData = null;

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ProjectService $projectService,
    ) {
    }

    #[LiveAction]
    public function save(#[LiveArg] ?string $route): ?Response
    {
        $this->submitForm();
        /** @var Project $project */
        $project = $this->getForm()->getData();

        $this->projectService->save($project);

        if (!is_null($route)) {
            return $this->redirectToRoute($route, [
                'id' => $project->getId(),
            ]);
        }

        return $this->redirectToRoute('Project-data-management-plans', ['id' => $project->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(ProjectDataManagementPlansType::class, $this->initialFormData, [
            'data_management_plan_choices' => $this->em->getRepository(DataManagementPlan::class)->findBy(['owner' => $this->getUser()]),
        ]);
    }
}
