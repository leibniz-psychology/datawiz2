<?php


namespace App\View\Controller;


use App\Domain\Model\DataWizUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DevelopmentLoginController extends NamingAwareController
{
    private $entitymanager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entitymanager = $entityManager;
    }

    /**
     * @Route("/login", name="dw_dev_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $user = $this->entitymanager
            ->getRepository(DataWizUser::class)
            ->find('dummy');

        if ($user === null)
        {
            $user = new DataWizUser('dummy');
            $this->entitymanager->persist($user);
            $this->entitymanager->flush();
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('Pages/developmentlogin.html.twig',
        [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="dw_dev_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}