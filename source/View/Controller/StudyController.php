<?php

namespace App\View\Controller;

use App\Crud\Crudable;
use App\Domain\Model\Study\Experiment;
use App\Domain\Model\Study\SettingsMetaDataGroup;
use App\Questionnaire\Fields\ShortNameSubscriber;
use App\Questionnaire\Forms\StudySettingsType;
use App\Questionnaire\Questionable;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Uid\Uuid;

class StudyController extends DataWizController
{
    private $currentUser;

    public function __construct(Security $security)
    {
        $this->currentUser = $security->getUser();
    }

    public function overviewAction(Crudable $crud):Response
    {
        $all_experiments = $crud->readForAll(Experiment::class);
        return $this->render('Pages/Study/overview.html.twig', [
            'all_experiments' => $all_experiments
        ]);
    }

    public function newAction(Questionable $questionnaire, Crudable $crud, Request $request): Response
    {

        $newExperiment = Experiment::createNewExperiment($this->currentUser);
        $form = $this->createFormBuilder($newExperiment->getSettingsMetaDataGroup())
            ->addEventSubscriber(new ShortNameSubscriber())
            ->add('new', SubmitType::class )
            ->getForm();

        $form->handleRequest($request);
        if ($questionnaire->submittedAndValid($form)) {
            $crud->update($newExperiment);
        }

        return $this->render('Pages/Study/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function settingsAction(string $uuid, Questionable $questionaire, Crudable $crud, Request $request): Response
    {
        /**
         * @var \App\Domain\Model\Study\Experiment
         */
        $entityAtChange = $crud->readById(Experiment::class, $uuid);

        $form = $questionaire->createAndHandleForm(StudySettingsType::class,
                                                    $request,
                                                    $entityAtChange->getSettingsMetaDataGroup());

        if ($questionaire->submittedAndValid($form)) {
            $crud->update($entityAtChange);
        }

        return $this->render('Pages/Study/settings.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function documentationAction(): Response
    {
        return $this->render('Pages/Study/documentation.html.twig');
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
}
