<?php

namespace App\Controller;

use App\Entity\Administration\DataWizUser;
use App\Entity\Constant\States;
use App\Entity\Study\Experiment;
use App\Service\Crud\Crudable;
use App\Service\Questionnaire\Questionnairable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/studies', name: 'Study-')]
#[IsGranted('ROLE_USER')]
class StudyController extends AbstractController
{
    public function __construct(
        private readonly Security $security,
        private readonly Questionnairable $questionnaire,
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

    #[Route(path: '/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Questionnairable $questionnaire, Request $request): Response
    {
        $this->logger->debug('Enter StudyController::newAction');
        $newExperiment = Experiment::createNewExperiment($this->em->getRepository(DataWizUser::class)->find($this->security->getUser()));
        $form = $questionnaire->askAndHandle($newExperiment->getSettingsMetaDataGroup(), 'create', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $newExperiment->setDateCreated(new \DateTime());
            $newExperiment->setDateSubmitted(null);
            $newExperiment->setState(States::STATE_STUDY_NONE);
            $this->em->persist($newExperiment);
            $this->em->flush();

            return $this->redirectToRoute('Study-introduction', ['id' => $newExperiment->getId()]);
        }

        return $this->render('pages/study/new.html.twig', [
            'form' => $form,
            'experiment' => $newExperiment,
        ]);
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

        return $this->render('pages/study/documentation.html.twig', [
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
