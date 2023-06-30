<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_REVIEWER')]
class ModerationController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    #[Route(path: '/moderation/dashboard', name: 'moderation_dashboard', methods: ['GET'])]
    public function dashboard(): Response
    {
        $this->logger->debug('AdministrationController::dashboard: Enter');

        return $this->render('pages/administration/moderation/dashboard.html.twig');
    }
}
