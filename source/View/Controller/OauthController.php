<?php


namespace App\View\Controller;


use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class OauthController extends AbstractController
{
    private $clientRegistry;

    public function __construct(ClientRegistry $clientRegistry)
    {
        $this->clientRegistry = $clientRegistry;
    }

    public function loginAction(): RedirectResponse
    {
        return $this->clientRegistry->getClient('keycloak')->redirect(['openid'], []);
    }

    public function loginCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
    }

    public function logoutAction()
    {
    }

}