<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractController
{
    #[Route(path: '/', name: 'landing', methods: ['GET'])]
    public function landing(): Response
    {
        return $this->render('pages/administration/landing.html.twig');
    }

    #[Route(path: '/dashboard', name: 'dashboard', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function dashboard(): Response
    {
        return $this->render('pages/administration/dashboard.html.twig');
    }
}
