<?php

namespace App\View\Controller;

use App\Domain\Definition\UserRoles;
use Exception;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{


    private LoggerInterface $logger;
    private KernelInterface $kernel;

    /**
     * @param LoggerInterface $logger
     * @param KernelInterface $kernel
     */
    public function __construct(LoggerInterface $logger, KernelInterface $kernel)
    {
        $this->logger = $logger;
        $this->kernel = $kernel;
    }


    /**
     * @Route(
     *     "/admin/install",
     *     name="dw_install"
     * )
     *
     * @return Response
     * @throws Exception
     */
    public function installDW(): Response
    {
        $this->logger->debug("UserController::installDW: Enter");
        $application = new Application($this->kernel);
        $application->setAutoExit(false);
        $command = new ArrayInput([
                                      'command' => 'pax:add-user-role',
                                      'email' => 'boelter@uni-trier.de',
                                      'role' => UserRoles::ADMINISTRATOR,
                                  ]);
        $application->run($command, new NullOutput());
        $command = new ArrayInput([
                                      'command' => 'pax:add-user-role',
                                      'email' => 'rb@leibniz-psychology.org',
                                      'role' => UserRoles::ADMINISTRATOR,
                                  ]);
        $application->run($command, new NullOutput());

        return $this->redirectToRoute('moderation_dashboard');
    }
}