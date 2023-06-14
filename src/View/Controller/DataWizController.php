<?php

namespace App\View\Controller;

use App\Crud\Crudable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class DataWizController extends AbstractController
{
    public function __construct(protected Crudable $crud, protected UrlGeneratorInterface $urlGenerator)
    {
    }

    abstract protected function getEntityAtChange(string $uuid, string $className);
}
