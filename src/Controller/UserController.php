<?php

namespace App\Controller;

use App\Domain\Definition\UserRoles;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class UserController extends AbstractController
{
    public function __construct(private readonly LoggerInterface $logger, private readonly KernelInterface $kernel)
    {
    }

    /**
     * @throws \Exception
     */
    #[Route(path: '/admin/install', name: 'dw_install')]
    public function installDW(): Response
    {
        $this->logger->debug('UserController::installDW: Enter');
        $application = new Application($this->kernel);
        $application->setAutoExit(false);
        $command = new ArrayInput([
            'command' => 'dw:add-user-role',
            'email' => 'boelter@uni-trier.de',
            'role' => UserRoles::ADMINISTRATOR,
        ]);
        $application->run($command, new NullOutput());
        $command = new ArrayInput([
            'command' => 'dw:add-user-role',
            'email' => 'rb@leibniz-psychology.org',
            'role' => UserRoles::ADMINISTRATOR,
        ]);
        $application->run($command, new NullOutput());

        return $this->redirectToRoute('moderation_dashboard');
    }
}
