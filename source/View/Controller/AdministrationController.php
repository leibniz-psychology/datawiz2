<?php

namespace App\View\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/administration", name="Administration-")
 *
 * Class AdministrationController
 * @package App\View\Controller
 */
class AdministrationController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     *
     * @param Security $security
     * @return Response
     */
    public function profileAction(Security $security): Response
    {
        return $this->render('Pages/Administration/profile.html.twig', [
            'currentUser' => $security->getUser(),
        ]);
    }

    /**
     * @Route("/landing", name="landing")
     *
     * @return Response
     */
    public function landingAction(): Response
    {
        return $this->render('Pages/Administration/landing.html.twig');
    }

    /**
     * @Route("/dashboard", name="dashboard")
     *
     * @return Response
     */
    public function dashboardAction(): Response
    {
        return $this->render('Pages/Administration/dashboard.html.twig');
    }
}
