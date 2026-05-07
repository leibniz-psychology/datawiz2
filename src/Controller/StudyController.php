<?php

namespace App\Controller;

use App\Entity\Study\Experiment;
use App\Service\Crud\Crudable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/studies', name: 'Study-')]
#[IsGranted('ROLE_USER')]
class StudyController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly LoggerInterface $logger,
        private readonly Crudable $crud
    ) {
    }

    #[Route(path: '/', name: 'overview', methods: ['GET'])]
    public function overview(): Response
    {
        $this->logger->debug('Enter StudyController::overviewAction');

        return $this->render('pages/study/overview.html.twig', [
            'all_experiments' => $this->em->getRepository(Experiment::class)->findBy(['owner' => $this->getUser()]),
        ]);
    }

    #[Route(path: '/new', name: 'new', methods: ['GET'])]
    public function new(): Response
    {
        $this->logger->debug('Enter StudyController::newAction');

        return $this->render('pages/study/new.html.twig');
    }

    #[Route(path: '/{id}/settings', name: 'settings')]
    public function settings(Experiment $experiment): Response
    {
        $this->logger->debug("Enter StudyController::settingsAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        return $this->render('pages/study/settings.html.twig', [
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/documentation', name: 'documentation')]
    public function documentation(Experiment $experiment): Response
    {
        $this->logger->debug("Enter StudyController::documentationAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        return $this->render('pages/study/basic_information.html.twig', [
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/theory', name: 'theory')]
    public function theory(Experiment $experiment): Response
    {
        $this->logger->debug("Enter StudyController::theoryAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        return $this->render('pages/study/theory.html.twig', [
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/sample', name: 'sample')]
    public function sample(Experiment $experiment): Response
    {
        $this->logger->debug("Enter StudyController::sampleAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        return $this->render('pages/study/sample.html.twig', [
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/measure', name: 'measure')]
    public function measure(Experiment $experiment): Response
    {
        $this->logger->debug("Enter StudyController::measureAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        return $this->render('pages/study/measure.html.twig', [
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/method', name: 'method')]
    public function method(Experiment $experiment): Response
    {
        $this->logger->debug("Enter StudyController::methodAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        return $this->render('pages/study/method.html.twig', [
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/ethics', name: 'ethics')]
    public function ethics(Experiment $experiment): Response
    {
        $this->logger->debug("Enter StudyController::ethicsAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        return $this->render('pages/study/ethics.html.twig', [
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/materials', name: 'materials')]
    public function materials(Experiment $experiment): Response
    {
        $this->logger->debug("Enter StudyController::materialsAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        return $this->render('pages/study/materials.html.twig', [
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/datasets', name: 'datasets')]
    public function datasets(Experiment $experiment): Response
    {
        $this->logger->debug("Enter StudyController::datasetsAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        return $this->render('pages/study/datasets.html.twig', [
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/introduction', name: 'introduction')]
    public function introduction(Experiment $experiment): Response
    {
        $this->logger->debug("Enter StudyController::introductionAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        return $this->render('pages/study/introduction.html.twig', [
            'experiment' => $experiment,
        ]);
    }

    #[Route(path: '/{id}/delete', name: 'delete')]
    public function delete(Experiment $experiment): Response
    {
        $this->logger->debug("Enter StudyController::deleteAction with [UUID: {$experiment->getId()}]");

        $this->denyAccessUnlessGranted('EDIT', $experiment);

        $this->crud->deleteStudy($experiment);

        return $this->redirectToRoute('Study-overview');
    }
}
