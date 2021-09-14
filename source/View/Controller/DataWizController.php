<?php

namespace App\View\Controller;

use App\Crud\Crudable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class DataWizController extends AbstractController
{
    protected Crudable $crud;
    protected UrlGeneratorInterface $urlGenerator;
    protected EntityManagerInterface $em;
    protected LoggerInterface $logger;

    /**
     * @param Crudable $crud
     * @param UrlGeneratorInterface $urlGenerator
     * @param EntityManagerInterface $em
     * @param LoggerInterface $logger
     */
    public function __construct(Crudable $crud, UrlGeneratorInterface $urlGenerator, EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->crud = $crud;
        $this->urlGenerator = $urlGenerator;
        $this->em = $em;
        $this->logger = $logger;
    }


    abstract protected function getEntityAtChange(string $uuid, string $className);
}
