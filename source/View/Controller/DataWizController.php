<?php

namespace App\View\Controller;

use App\Crud\Crudable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class DataWizController extends AbstractController
{
    protected Crudable $crud;
    protected UrlGeneratorInterface $urlGenerator;

    public function __construct(Crudable $crud, UrlGeneratorInterface $urlGenerator)
    {
        $this->crud = $crud;
        $this->urlGenerator = $urlGenerator;
    }

    abstract protected function getEntityAtChange(string $uuid, string $className);
}
