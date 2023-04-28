<?php

namespace App\View\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route(path: '/', name: 'landing')]
    public function landingAction(): Response
    {
        return $this->render('Pages/Administration/landing.html.twig');
    }

    #[Route(path: '/dashboard', name: 'dashboard')]
    #[IsGranted('ROLE_USER')]
    public function dashboardAction(): Response
    {
        return $this->render('Pages/Administration/dashboard.html.twig');
    }

}