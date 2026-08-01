<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Project\Project;
use App\Entity\Project\ProjectAdministrativeData;
use App\Entity\Project\ProjectSettings;
use App\Service\Crud\Crudable;
use App\Service\Project\ProjectService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/projects', name: 'Project-')]
#[IsGranted('ROLE_USER')]
class ProjectController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ProjectService $projectService,
        private readonly Crudable $crud,
    ) {
    }

    #[Route(path: '/', name: 'overview', methods: ['GET'])]
    public function overview(): Response
    {
        $this->logger->debug('Enter ProjectController::overview');

        $projects = $this->projectService->findByOwner($this->getUser());

        return $this->render('pages/project/overview.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route(path: '/new', name: 'new', methods: ['GET'])]
    public function new(): Response
    {
        $this->logger->debug('Enter ProjectController::new');

        return $this->render('pages/project/new.html.twig');
    }

    #[Route(path: '/{id}/introduction', name: 'introduction', methods: ['GET'])]
    public function introduction(Project $project): Response
    {
        $this->logger->debug("Enter ProjectController::introduction with [UUID: {$project->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $project);

        return $this->render('pages/project/introduction.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route(path: '/{id}/edit/administrative', name: 'edit-administrative', methods: ['GET'])]
    public function editAdministrativeData(Project $project): Response
    {
        $this->logger->debug("Enter ProjectController::editAdministrativeData with [UUID: {$project->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $project);

        if ($project->getAdministrativeData() === null) {
            $project->setAdministrativeData(new ProjectAdministrativeData());
            $this->projectService->save($project);
        }

        return $this->render('pages/project/administrative_data.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route(path: '/{id}/materials', name: 'materials', methods: ['GET'])]
    public function materials(Project $project): Response
    {
        $this->logger->debug("Enter ProjectController::materials with [UUID: {$project->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $project);

        return $this->render('pages/project/materials.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route(path: '/{id}/review', name: 'review', methods: ['GET'])]
    public function review(Project $project): Response
    {
        $this->logger->debug("Enter ProjectController::review with [UUID: {$project->getId()}]");

        $this->denyAccessUnlessGranted('REVIEW', $project);

        return $this->render('pages/project/review.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route(path: '/{id}/settings', name: 'settings', methods: ['GET'])]
    public function settings(Project $project): Response
    {
        $this->logger->debug("Enter ProjectController::settings with [UUID: {$project->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $project);

        if ($project->getSettings() === null) {
            $project->setSettings(new ProjectSettings());
            $this->projectService->save($project);
        }

        return $this->render('pages/project/settings.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route(path: '/{id}/delete', name: 'delete', methods: ['GET'])]
    public function delete(Project $project): Response
    {
        $this->logger->debug("Enter ProjectController::delete with [UUID: {$project->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $project);

        $this->crud->deleteProject($project);

        return $this->redirectToRoute('Project-overview');
    }
}
