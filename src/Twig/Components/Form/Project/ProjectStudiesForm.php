<?php

declare(strict_types=1);

namespace App\Twig\Components\Form\Project;

use App\Entity\Project\Project;
use App\Entity\Study\Experiment;
use App\Form\Project\ProjectStudiesType;
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
class ProjectStudiesForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use ProjectFormTrait;

    public const string formType = 'studies';

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

        return $this->redirectToRoute('Project-studies', ['id' => $project->getId()]);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(ProjectStudiesType::class, $this->initialFormData, [
            'experiment_choices' => $this->em->getRepository(Experiment::class)->findBy(['owner' => $this->getUser()]),
        ]);
    }
}
