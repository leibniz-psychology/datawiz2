<?php

namespace App\View\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class AdministrationController extends AbstractController
{
    public function profileAction(Security $security): Response
    {
        return $this->render('Pages/Administration/profile.html.twig', [
            'currentUser' => $security->getUser(),
        ]);
    }

    public function landingAction(): Response
    {
        return $this->render('Pages/Administration/landing.html.twig');
    }

    public function dashboardAction(): Response
    {
        return $this->render('Pages/Administration/dashboard.html.twig');
    }
}
