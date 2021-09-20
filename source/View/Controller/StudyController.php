<?php

namespace App\View\Controller;

use App\Crud\Crudable;
use App\Crud\CrudService;
use App\Domain\Model\Study\Experiment;
use App\Questionnaire\Questionnairable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/studies", name="Study-")
 * @IsGranted("ROLE_USER")
 *
 * Class StudyController
 * @package App\View\Controller
 */
class StudyController extends AbstractController
{
    private Security $security;
    private Questionnairable $questionnaire;
    private EntityManagerInterface $em;
    private LoggerInterface $logger;
    private Crudable $crud;

    /**
     * @param Security $security
     * @param Questionnairable $questionnaire
     * @param EntityManagerInterface $em
     * @param LoggerInterface $logger
     * @param Crudable $crud
     */
    public function __construct(Security $security, Questionnairable $questionnaire, EntityManagerInterface $em, LoggerInterface $logger, Crudable $crud)
    {
        $this->security = $security;
        $this->questionnaire = $questionnaire;
        $this->em = $em;
        $this->logger = $logger;
        $this->crud = $crud;
    }


    /**
     * @Route("/", name="overview")
     *
     * @return Response
     */
    public function overviewAction(): Response
    {
        $this->logger->debug("Enter StudyController::overviewAction");

        return $this->render('Pages/Study/overview.html.twig', [
            'all_experiments' => $this->em->getRepository(Experiment::class)->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new")
     *
     * @param Questionnairable $questionnaire
     * @param Crudable $crud
     * @param Request $request
     * @return Response
     */
    public function newAction(Questionnairable $questionnaire, Crudable $crud, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::newAction");
        $newExperiment = Experiment::createNewExperiment($this->security->getUser());
        $form = $questionnaire->askAndHandle($newExperiment->getSettingsMetaDataGroup(), 'create', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($newExperiment);
            $this->em->flush();

            return $this->redirectToRoute('Study-introduction', ['uuid' => $newExperiment->getId()]);
        }

        return $this->render('Pages/Study/new.html.twig', [
            'form' => $form->createView(),
            'experiment' => $newExperiment,
        ]);
    }

    /**
     * @Route("/{uuid}/settings", name="settings")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function settingsAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::settingsAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);
        $form = $this->questionnaire->askAndHandle($entityAtChange->getSettingsMetaDataGroup(), 'save', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($entityAtChange);
            $this->em->flush();
        }

        return $this->render('Pages/Study/settings.html.twig', [
            'form' => $form->createView(),
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/documentation", name="documentation")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function documentationAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::documentationAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);
        $form = $this->questionnaire->askAndHandle($entityAtChange->getBasicInformationMetaDataGroup(), 'save', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($entityAtChange);
            $this->em->flush();
        }

        return $this->render('Pages/Study/documentation.html.twig', [
            'form' => $form->createView(),
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/theory", name="theory")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function theoryAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::theoryAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);
        $form = $this->questionnaire->askAndHandle($entityAtChange->getTheoryMetaDataGroup(), 'save', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($entityAtChange);
            $this->em->flush();
        }

        return $this->render('Pages/Study/theory.html.twig', [
            'form' => $form->createView(),
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/sample", name="sample")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function sampleAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::sampleAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);
        $form = $this->questionnaire->askAndHandle($entityAtChange->getSampleMetaDataGroup(), 'save', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($entityAtChange);
            $this->em->flush();
        }

        return $this->render('Pages/Study/sample.html.twig', [
            'form' => $form->createView(),
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/measure", name="measure")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function measureAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::measureAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);
        $form = $this->questionnaire->askAndHandle($entityAtChange->getMeasureMetaDataGroup(), 'save', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($entityAtChange);
            $this->em->flush();
        }

        return $this->render('Pages/Study/measure.html.twig', [
            'form' => $form->createView(),
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/method", name="method")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function methodAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter StudyController::methodAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);
        $form = $this->questionnaire->askAndHandle($entityAtChange->getMethodMetaDataGroup(), 'save', $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($entityAtChange);
            $this->em->flush();
        }

        return $this->render('Pages/Study/method.html.twig', [
            'form' => $form->createView(),
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/materials", name="materials")
     *
     * @param string $uuid
     * @return Response
     */
    public function materialsAction(string $uuid): Response
    {
        $this->logger->debug("Enter StudyController::materialsAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);

        return $this->render('Pages/Study/materials.html.twig', [
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/datasets", name="datasets")
     *
     * @param string $uuid
     * @return Response
     */
    public function datasetsAction(string $uuid): Response
    {
        $this->logger->debug("Enter StudyController::datasetsAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);

        return $this->render('Pages/Study/datasets.html.twig', [
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/introduction", name="introduction")
     *
     * @param string $uuid
     * @return Response
     */
    public function introductionAction(string $uuid): Response
    {
        $this->logger->debug("Enter StudyController::introductionAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);

        return $this->render('Pages/Study/introduction.html.twig', [
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/delete", name="delete")
     *
     * @param string $uuid
     * @return Response
     */
    public function deleteAction(string $uuid): Response
    {
        $this->logger->debug("Enter StudyController::deleteAction with [UUID: $uuid]");
        $entityAtChange = $this->getEntityAtChange($uuid);
        $result = $this->crud->deleteStudy($entityAtChange);

        return $this->redirectToRoute('Study-overview');
    }


    protected function getEntityAtChange(string $uuid, string $className = Experiment::class)
    {
        return $this->em->getRepository($className)->find($uuid);
    }
}
