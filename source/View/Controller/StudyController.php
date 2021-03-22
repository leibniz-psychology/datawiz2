<?php

namespace App\View\Controller;

use App\Crud\Crudable;
use App\Domain\Model\Administration\UuidEntity;
use App\Domain\Model\Study\Experiment;
use App\Domain\Model\Study\SettingsMetaDataGroup;
use App\Questionnaire\Forms\BasicInformationType;
use App\Questionnaire\Forms\StudySettingsType;
use App\Questionnaire\Questionnairable;
use phpDocumentor\Reflection\Types\This;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Uid\Uuid;

class StudyController extends DataWizController
{
    private $currentUser;
    private $questionnaire;
    private $crud;

    public function __construct(Security $security,
                                Questionnairable $questionnaire,
                                Crudable $crud)
    {
        $this->currentUser = $security->getUser();
        $this->crud = $crud;
        $this->questionnaire = $questionnaire;
    }

    public function overviewAction(Crudable $crud):Response
    {
        $all_experiments = $crud->readForAll(Experiment::class);
        return $this->render('Pages/Study/overview.html.twig', [
            'all_experiments' => $all_experiments
        ]);
    }

    public function newAction(Questionnairable $questionnaire, Crudable $crud, Request $request): Response
    {
        $newExperiment = Experiment::createNewExperiment($this->currentUser);
        $form = $this->createFormBuilder($newExperiment->getSettingsMetaDataGroup())
            ->add('shortName', TextType::class, SettingsMetaDataGroup::getShortNameOptions())
            ->add('new', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($questionnaire->submittedAndValid($form)) {
            $crud->update($newExperiment);
        }

        return $this->render('Pages/Study/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function settingsAction(string $uuid, Request $request): Response
    {
        $entityAtChange = $this->getExperimentForSlug($uuid);

        $form = $this->questionnaire
            ->createAndHandleForm(StudySettingsType::class,
                $request,
                $entityAtChange->getSettingsMetaDataGroup());

        if ($this->questionnaire->submittedAndValid($form)) {
            $this->crud->update($entityAtChange);
        }

        return $this->render('Pages/Study/settings.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function documentationAction(string $uuid, Request $request): Response
    {
        $entityAtChange = $this->getExperimentForSlug($uuid);

        $form = $this->questionnaire
            ->createAndHandleForm(BasicInformationType::class,
            $request,
            $entityAtChange->getBasicInformationMetaDataGroup());

        if ($this->questionnaire->submittedAndValid($form)) {
            $this->crud->update($entityAtChange);
        }

        return $this->render('Pages/Study/documentation.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function adminAction(): Response
    {
        return $this->render('Pages/Study/admin.html.twig');
    }

    public function designAction(): Response
    {
        return $this->render('Pages/Study/design.html.twig');
    }

    public function theoryAction(): Response
    {
        return $this->render('Pages/Study/theory.html.twig');
    }

    public function sampleAction(): Response
    {
        return $this->render('Pages/Study/sample.html.twig');
    }

    private function getExperimentForSlug(string $uuid): Experiment
    {
        return $this->crud->readById(Experiment::class, $uuid);
    }
}
