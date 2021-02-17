<?php

namespace App\View\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DevelopmentLoginController extends AbstractController
{
    private $authenticationUtils;
    private $em;

    public function __construct(AuthenticationUtils $authenticationUtils, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->authenticationUtils = $authenticationUtils;
    }

    public function loginAction(): Response
    {
        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $this->authenticationUtils->getLastUsername();

        return $this->render('Pages/Security/developmentlogin.html.twig',
        [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    public function logoutAction(): Response
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
