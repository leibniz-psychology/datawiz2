<?php

namespace App\View\Controller;

use Symfony\Component\HttpFoundation\Response;

class StudyController extends DataWizController
{
    public function indexAction(): Response
    {
        return $this->render('Pages/Studies/index.html.twig');
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
