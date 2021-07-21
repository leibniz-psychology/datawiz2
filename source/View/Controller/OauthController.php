<?php


namespace App\View\Controller;


use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/security",
 *     name="Security-",
 *     condition="'%kernel.environment%' in ['dev', 'prod']"
 * )
 *
 * Class OauthController
 * @package App\View\Controller
 */
class OauthController extends AbstractController
{
    private $clientRegistry;

    public function __construct(ClientRegistry $clientRegistry)
    {
        $this->clientRegistry = $clientRegistry;
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(): RedirectResponse
    {
        return $this->clientRegistry->getClient('keycloak')->redirect(['openid'], []);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function loginCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
    }

    /**
     * @Route("/login/check", name="check")
     */
    public function logoutAction()
    {
    }

}