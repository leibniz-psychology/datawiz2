<?php

namespace App\View\Controller;

use App\Crud\Crudable;
use App\Questionnaire\Forms\StudySettingsType;
use App\Questionnaire\Questionable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StudyController extends DataWizController
{
    public function indexAction(Questionable $questionnaire, Crudable $crud, Request $request): Response
    {
        $form = $questionnaire->createAndHandleForm(StudySettingsType::class, $request);

        if ($questionnaire->submittedAndValid($form)) {
            $crud->update($form->getData());
        }

        return $this->render('Pages/Studies/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function newAction(): Response
    {
        return $this->render('Pages/Studies/new.html.twig');
    }

    public function documentationAction(): Response
    {
        return $this->render('Pages/Studies/documentation.html.twig');
    }

    public function adminAction(): Response
    {
        return $this->render('Pages/Studies/admin.html.twig');
    }

    public function designAction(): Response
    {
        return $this->render('Pages/Studies/design.html.twig');
    }

    public function theoryAction(): Response
    {
        return $this->render('Pages/Studies/theory.html.twig');
    }

    public function sampleAction(): Response
    {
        return $this->render('Pages/Studies/sample.html.twig');
    }
}
