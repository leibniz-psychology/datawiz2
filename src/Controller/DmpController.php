<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\DataManagementPlan\DataManagementPlan;
use App\Entity\DataManagementPlan\DmpResearchData;
use App\Service\DataManagementPlan\DataManagementPlanService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/data-management-plans', name: 'Dmp-')]
#[IsGranted('ROLE_USER')]
class DmpController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly DataManagementPlanService $dmpService,
    ) {
    }

    #[Route(path: '/', name: 'overview', methods: ['GET'])]
    public function overview(): Response
    {
        $this->logger->debug('Enter DmpController::overviewAction');

        $plans = $this->dmpService->findByOwner($this->getUser());

        return $this->render('pages/data_management/overview.html.twig', [
            'data_management_plans' => $plans,
        ]);
    }

    #[Route(path: '/new', name: 'new', methods: ['GET'])]
    public function new(): Response
    {
        $this->logger->debug('Enter DmpController::newAction');

        return $this->render('pages/data_management/new.html.twig');
    }

    #[Route(path: '/{id}/introduction', name: 'introduction', methods: ['GET'])]
    public function introduction(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::introductionAction with [UUID: {$dataManagementPlan->getId()}]");

        return $this->render('pages/data_management/introduction.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/edit/administrative', name: 'edit-administrative', methods: ['GET'])]
    public function editAdministrativeData(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::editAction with [UUID: {$dataManagementPlan->getId()}]");

        return $this->render('pages/data_management/administrative_data.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/edit/research-data', name: 'edit-research-data', methods: ['GET'])]
    public function editResearchData(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::editResearchData with [UUID: {$dataManagementPlan->getId()}]");

        if ($dataManagementPlan->getResearchData() === null) {
            $dataManagementPlan->setResearchData(new DmpResearchData());
            $this->dmpService->save($dataManagementPlan);
        }

        return $this->render('pages/data_management/research_data.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/review', name: 'review', methods: ['GET'])]
    public function review(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::reviewAction with [UUID: {$dataManagementPlan->getId()}]");

        return $this->render('pages/data_management/review.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/settings', name: 'settings', methods: ['GET'])]
    public function settings(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::settingsAction with [UUID: {$dataManagementPlan->getId()}]");

        return $this->render('pages/data_management/settings.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/delete', name: 'delete', methods: ['GET'])]
    public function delete(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::deleteAction with [UUID: {$dataManagementPlan->getId()}]");

        $this->dmpService->remove($dataManagementPlan);

        return $this->redirectToRoute('Dmp-overview');
    }
}
