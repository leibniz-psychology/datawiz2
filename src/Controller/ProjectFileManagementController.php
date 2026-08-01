<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Project\ProjectMaterial;
use App\Service\Crud\Crudable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/project-filemanagement', name: 'ProjectFile-')]
#[IsGranted('ROLE_USER')]
class ProjectFileManagementController extends AbstractController
{
    public function __construct(
        private readonly Crudable $crud,
        private readonly EntityManagerInterface $em,
        private readonly LoggerInterface $logger
    ) {
    }

    #[Route(path: '/{id}/delete/material', name: 'delete_material', methods: ['POST'])]
    public function deleteMaterial(ProjectMaterial $material): RedirectResponse
    {
        $this->logger->debug("Enter ProjectFileManagementController::deleteMaterial with [UUID: {$material->getId()}]");
        $this->denyAccessUnlessGranted('EDIT', $material->getProject());
        $projectId = $material->getProject()->getId();
        $this->crud->deleteProjectMaterial($material);

        return $this->redirectToRoute('Project-materials', ['id' => $projectId]);
    }

    #[Route(path: '/{id}/update/description', name: 'update_description', methods: ['POST'])]
    public function updateDescription(ProjectMaterial $material, Request $request): JsonResponse
    {
        $this->logger->debug("Enter ProjectFileManagementController::updateDescription with [UUID: {$material->getId()}]");
        $this->denyAccessUnlessGranted('EDIT', $material->getProject());

        $description = $request->getContent();
        $material->setDescription($description);
        $this->em->persist($material);
        $this->em->flush();

        return new JsonResponse(['success' => true], Response::HTTP_OK);
    }
}
