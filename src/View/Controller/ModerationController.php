<?php

namespace App\View\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_REVIEWER")
 */
class ModerationController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em, private readonly LoggerInterface $logger)
    {
    }


    /**
     * @Route(
     *     "/moderation/dashboard",
     *      name="moderation_dashboard"
     * )
     */
    public function dashboard(): Response
    {
        $this->logger->debug("AdministrationController::dashboard: Enter");

        return $this->render('Pages/Administration/moderation/dashboard.html.twig');
    }

}