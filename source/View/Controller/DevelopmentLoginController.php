<?php

namespace App\View\Controller;

use App\Crud\Crudable;
use App\Domain\Model\Administration\DataWizUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/security",
 *     name="Security-",
 *     condition="'%kernel.environment%' in ['local', 'test']")
 *
 * Class DevelopmentLoginController
 * @package App\View\Controller
 */
class DevelopmentLoginController extends AbstractController
{
    private $authenticationUtils;
    private $crud;

    public function __construct(AuthenticationUtils $authenticationUtils, Crudable $crud)
    {
        $this->authenticationUtils = $authenticationUtils;
        $this->crud = $crud;
    }

    /**
     * @Route("/login", name="login-dev")
     */
    public function loginAction(): Response
    {
        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $this->authenticationUtils->getLastUsername();

        $all_users = $this->crud->readForAll(DataWizUser::class);

        return $this->render('Pages/Security/developmentlogin.html.twig',
        [
            'last_username' => $lastUsername,
            'error' => $error,
            'all_users' => $all_users,
        ]);
    }

    /**
     * @Route("/logout", name="logout-dev")
     */
    public function logoutAction(): Response
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
