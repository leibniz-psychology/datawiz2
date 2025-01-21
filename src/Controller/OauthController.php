<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/security', name: 'Security-', condition: "'%kernel.environment%' in ['dev', 'prod']")]
class OauthController extends AbstractController
{
    public function __construct(private readonly ClientRegistry $clientRegistry) {}

    #[Route(path: '/login', name: 'login', methods: ['GET'])]
    public function loginAction(): RedirectResponse
    {
        return $this->clientRegistry->getClient('keycloak')->redirect(['openid'], []);
    }

    #[Route(path: '/logout', name: 'logout', methods: ['GET'])]
    public function logoutAction(ClientRegistry $clientRegistry) {}

    #[Route(path: '/login/check', name: 'check', methods: ['GET'])]
    public function loginCheckAction() {}
}
