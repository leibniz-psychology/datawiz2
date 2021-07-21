<?php

namespace App\View\Controller;

use App\Crud\Crudable;
use App\Domain\Model\Study\Experiment;
use App\Questionnaire\Questionnairable;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/studies", name="Study-")
 *
 * Class StudyController
 * @package App\View\Controller
 */
class StudyController extends DataWizController
{
    private $currentUser;
    private $questionnaire;

    public function __construct(Security $security, Questionnairable $questionnaire,
                                Crudable $crud, UrlGeneratorInterface $urlGenerator)
    {
        parent::__construct($crud, $urlGenerator);
        $this->currentUser = $security->getUser();
        $this->questionnaire = $questionnaire;
    }

    /**
     * @Route("/overview", name="overview")
     *
     * @return Response
     */
    public function overviewAction(): Response
    {
        $all_experiments = $this->crud->readForAll(Experiment::class);

        return $this->render('Pages/Study/overview.html.twig', [
            'all_experiments' => $all_experiments,
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
        $newExperiment = Experiment::createNewExperiment($this->currentUser);

        $form = $questionnaire->askAndHandle(
            $newExperiment->getSettingsMetaDataGroup(),
            'create',
            $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->crud->update($newExperiment);

            return new RedirectResponse($this->urlGenerator
                ->generate('Study-introduction',
                    [ 'uuid' => $newExperiment->getId() ])
            );
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
        $entityAtChange = $this->getEntityAtChange($uuid);

        $form = $this->questionnaire->askAndHandle(
            $entityAtChange->getSettingsMetaDataGroup(),
            'save',
            $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->crud->update($entityAtChange);
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
        $entityAtChange = $this->getEntityAtChange($uuid);

        $form = $this->questionnaire->askAndHandle(
            $entityAtChange->getBasicInformationMetaDataGroup(),
            'save',
            $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->crud->update($entityAtChange);
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
        $entityAtChange = $this->getEntityAtChange($uuid);

        $form = $this->questionnaire->askAndHandle(
            $entityAtChange->getTheoryMetaDataGroup(),
            'save',
            $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->crud->update($entityAtChange);
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
        $entityAtChange = $this->getEntityAtChange($uuid);

        $form = $this->questionnaire->askAndHandle(
            $entityAtChange->getSampleMetaDataGroup(),
            'save',
            $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->crud->update($entityAtChange);
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
        $entityAtChange = $this->getEntityAtChange($uuid);

        $form = $this->questionnaire->askAndHandle(
            $entityAtChange->getMeasureMetaDataGroup(),
            'save',
            $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->crud->update($entityAtChange);
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
        $entityAtChange = $this->getEntityAtChange($uuid);

        $form = $this->questionnaire->askAndHandle(
            $entityAtChange->getMethodMetaDataGroup(),
            'save',
            $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->crud->update($entityAtChange);
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
        $entityAtChange = $this->getEntityAtChange($uuid);

        return $this->render('Pages/Study/datasets.html.twig', [
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/introduction", name="introduction")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function introductionAction(string $uuid, Request $request): Response
    {
        $entityAtChange = $this->getEntityAtChange($uuid);

        return $this->render('Pages/Study/introduction.html.twig', [
            'experiment' => $entityAtChange,
        ]);
    }

    /**
     * @Route("/{uuid}/review", name="review")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function reviewAction(string $uuid, Request $request): Response
    {
        $entityAtChange = $this->getEntityAtChange($uuid);

        return $this->render('Pages/Study/review.html.twig', [
            'experiment' => $entityAtChange,
        ]);
    }

    protected function getEntityAtChange(string $uuid, string $className = Experiment::class)
    {
        return $this->crud->readById($className, $uuid);
    }
}
