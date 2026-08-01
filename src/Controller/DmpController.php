<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\DataManagementPlan\DataManagementPlan;
use App\Entity\DataManagementPlan\DmpAdministrativeData;
use App\Entity\DataManagementPlan\DmpCosts;
use App\Entity\DataManagementPlan\DmpDataSharing;
use App\Entity\DataManagementPlan\DmpDocumentation;
use App\Entity\DataManagementPlan\DmpEthicalLegal;
use App\Entity\DataManagementPlan\DmpOrganizationPolicies;
use App\Entity\DataManagementPlan\DmpResearchData;
use App\Entity\DataManagementPlan\DmpSettings;
use App\Entity\DataManagementPlan\DmpStorageInfrastructure;
use App\Service\DataManagementPlan\DataManagementPlanService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path: '/data-management-plans', name: 'Dmp-')]
#[IsGranted('ROLE_USER')]
class DmpController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly DataManagementPlanService $dmpService,
        private readonly SerializerInterface $serializer,
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

        $this->denyAccessUnlessGranted('EDIT', $dataManagementPlan);

        return $this->render('pages/data_management/introduction.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/edit/administrative', name: 'edit-administrative', methods: ['GET'])]
    public function editAdministrativeData(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::editAction with [UUID: {$dataManagementPlan->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $dataManagementPlan);

        if ($dataManagementPlan->getAdministrativeData() === null) {
            $dataManagementPlan->setAdministrativeData(new DmpAdministrativeData());
            $this->dmpService->save($dataManagementPlan);
        }

        return $this->render('pages/data_management/administrative_data.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/edit/ethical-legal', name: 'edit-ethical-legal', methods: ['GET'])]
    public function editEthicalLegal(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::editEthicalLegal with [UUID: {$dataManagementPlan->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $dataManagementPlan);

        if ($dataManagementPlan->getEthicalLegal() === null) {
            $dataManagementPlan->setEthicalLegal(new DmpEthicalLegal());
            $this->dmpService->save($dataManagementPlan);
        }

        return $this->render('pages/data_management/ethical_legal.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/edit/organization-policies', name: 'edit-organization-policies', methods: ['GET'])]
    public function editOrganizationPolicies(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::editOrganizationPolicies with [UUID: {$dataManagementPlan->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $dataManagementPlan);

        if ($dataManagementPlan->getOrganizationPolicies() === null) {
            $dataManagementPlan->setOrganizationPolicies(new DmpOrganizationPolicies());
            $this->dmpService->save($dataManagementPlan);
        }

        return $this->render('pages/data_management/organization_policies.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/edit/storage-infrastructure', name: 'edit-storage-infrastructure', methods: ['GET'])]
    public function editStorageInfrastructure(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::editStorageInfrastructure with [UUID: {$dataManagementPlan->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $dataManagementPlan);

        if ($dataManagementPlan->getStorageInfrastructure() === null) {
            $dataManagementPlan->setStorageInfrastructure(new DmpStorageInfrastructure());
            $this->dmpService->save($dataManagementPlan);
        }

        return $this->render('pages/data_management/storage_infrastructure.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/edit/data-sharing', name: 'edit-data-sharing', methods: ['GET'])]
    public function editDataSharing(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::editDataSharing with [UUID: {$dataManagementPlan->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $dataManagementPlan);

        if ($dataManagementPlan->getDataSharing() === null) {
            $dataManagementPlan->setDataSharing(new DmpDataSharing());
            $this->dmpService->save($dataManagementPlan);
        }

        return $this->render('pages/data_management/data_sharing.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/edit/documentation', name: 'edit-documentation', methods: ['GET'])]
    public function editDocumentation(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::editDocumentation with [UUID: {$dataManagementPlan->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $dataManagementPlan);

        if ($dataManagementPlan->getDocumentation() === null) {
            $dataManagementPlan->setDocumentation(new DmpDocumentation());
            $this->dmpService->save($dataManagementPlan);
        }

        return $this->render('pages/data_management/documentation.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/edit/research-data', name: 'edit-research-data', methods: ['GET'])]
    public function editResearchData(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::editResearchData with [UUID: {$dataManagementPlan->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $dataManagementPlan);

        if ($dataManagementPlan->getResearchData() === null) {
            $dataManagementPlan->setResearchData(new DmpResearchData());
            $this->dmpService->save($dataManagementPlan);
        }

        return $this->render('pages/data_management/research_data.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/edit/costs', name: 'edit-costs', methods: ['GET'])]
    public function editCosts(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::editCosts with [UUID: {$dataManagementPlan->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $dataManagementPlan);

        if ($dataManagementPlan->getCosts() === null) {
            $dataManagementPlan->setCosts(new DmpCosts());
            $this->dmpService->save($dataManagementPlan);
        }

        return $this->render('pages/data_management/costs.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/review', name: 'review', methods: ['GET'])]
    public function review(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::reviewAction with [UUID: {$dataManagementPlan->getId()}]");

        $this->denyAccessUnlessGranted('REVIEW', $dataManagementPlan);

        return $this->render('pages/data_management/review.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/settings', name: 'settings', methods: ['GET'])]
    public function settings(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::settingsAction with [UUID: {$dataManagementPlan->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $dataManagementPlan);

        if ($dataManagementPlan->getSettings() === null) {
            $dataManagementPlan->setSettings(new DmpSettings());
            $this->dmpService->save($dataManagementPlan);
        }

        return $this->render('pages/data_management/settings.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/export', name: 'export', methods: ['GET'])]
    public function export(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::export with [UUID: {$dataManagementPlan->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $dataManagementPlan);

        return $this->render('pages/data_management/export.html.twig', [
            'dataManagementPlan' => $dataManagementPlan,
        ]);
    }

    #[Route(path: '/{id}/export', name: 'export-action', methods: ['POST'])]
    public function exportAction(DataManagementPlan $dataManagementPlan, Request $request): Response
    {
        $this->logger->debug("Enter DmpController::exportAction with [UUID: {$dataManagementPlan->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $dataManagementPlan);

        $format = $request->request->get('format', 'json');

        $content = $this->serializer->serialize(
            $dataManagementPlan,
            $format,
            [
                'xml_root_node_name' => 'data_management_plan',
                'xml_encoding' => 'utf-8',
                'xml_format_output' => true,
                AbstractNormalizer::GROUPS => ['data_management_plan'],
                'json_encode_options' => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
            ]
        );

        $filename = $this->sanitizeFilename($dataManagementPlan->getSettings()?->getShortName()).'.'.$format;

        return new Response(
            $content,
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/'.$format,
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
                'Content-Length' => strlen($content),
            ]
        );
    }

    #[Route(path: '/{id}/delete', name: 'delete', methods: ['GET'])]
    public function delete(DataManagementPlan $dataManagementPlan): Response
    {
        $this->logger->debug("Enter DmpController::deleteAction with [UUID: {$dataManagementPlan->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $dataManagementPlan);

        $this->dmpService->remove($dataManagementPlan);

        return $this->redirectToRoute('Dmp-overview');
    }

    private function sanitizeFilename(?string $name): string
    {
        $chars = [' ', '"', "'", '&', '/', '\\', '?', '#', '<', '>', '.', ','];

        return $name !== null ? strtolower(trim(str_replace($chars, '_', $name))) : 'data_management_plan';
    }
}
