<?php

namespace App\View\Controller;

use App\Crud\Crudable;
use App\Domain\Model\Study\Experiment;
use App\Questionnaire\Questionnairable;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class StudyController extends DataWizController
{
    private $currentUser;
    private $questionnaire;
    private $crud;
    private $urlGenerator;

    public function __construct(Security $security, Questionnairable $questionnaire,
                                Crudable $crud, UrlGeneratorInterface $urlGenerator)
    {
        $this->currentUser = $security->getUser();
        $this->crud = $crud;
        $this->questionnaire = $questionnaire;
        $this->urlGenerator = $urlGenerator;
    }

    public function overviewAction(Crudable $crud): Response
    {
        $all_experiments = $crud->readForAll(Experiment::class);

        return $this->render('Pages/Study/overview.html.twig', [
            'all_experiments' => $all_experiments,
        ]);
    }

    public function newAction(Questionnairable $questionnaire, Crudable $crud, Request $request): Response
    {
        $newExperiment = Experiment::createNewExperiment($this->currentUser);

        $form = $questionnaire->askAndHandle(
            $newExperiment->getSettingsMetaDataGroup(),
            'create',
            $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->crud->update($newExperiment);

            return $this->redirectToOverview();
        }

        return $this->render('Pages/Study/new.html.twig', [
            'form' => $form->createView(),
            'experiment' => $newExperiment,
        ]);
    }

    public function settingsAction(string $uuid, Request $request): Response
    {
        $entityAtChange = $this->getExperimentForUuid($uuid);

        $form = $this->questionnaire->askAndHandle(
            $entityAtChange->getSettingsMetaDataGroup(),
            'save',
            $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->crud->update($entityAtChange);

            return $this->redirectToOverview();
        }

        return $this->render('Pages/Study/settings.html.twig', [
            'form' => $form->createView(),
            'experiment' => $entityAtChange,
        ]);
    }

    public function documentationAction(string $uuid, Request $request): Response
    {
        $entityAtChange = $this->getExperimentForUuid($uuid);

        $form = $this->questionnaire->askAndHandle(
            $entityAtChange->getBasicInformationMetaDataGroup(),
            'save',
            $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->crud->update($entityAtChange);

            return $this->redirectToOverview();
        }

        return $this->render('Pages/Study/documentation.html.twig', [
            'form' => $form->createView(),
            'experiment' => $entityAtChange,
        ]);
    }

    public function adminAction(): Response
    {
        return $this->render('Pages/Study/admin.html.twig');
    }

    public function designAction(string $uuid, Request $request): Response
    {
        $entityAtChange = $this->getExperimentForUuid($uuid);

        return $this->render('Pages/Study/design.html.twig', [
            'experiment' => $entityAtChange,
        ]);
    }

    public function theoryAction(string $uuid, Request $request): Response
    {
        $entityAtChange = $this->getExperimentForUuid($uuid);

        return $this->render('Pages/Study/theory.html.twig', [
            'experiment' => $entityAtChange,
        ]);
    }

    public function sampleAction(string $uuid, Request $request): Response
    {
        $entityAtChange = $this->getExperimentForUuid($uuid);

        return $this->render('Pages/Study/sample.html.twig', [
            'experiment' => $entityAtChange,
        ]);
    }

    private function getExperimentForUuid(string $uuid): Experiment
    {
        return $this->crud->readById(Experiment::class, $uuid);
    }

    private function redirectToOverview(): RedirectResponse
    {
        return new RedirectResponse($this->urlGenerator->generate('Study-overview'));
    }
}
