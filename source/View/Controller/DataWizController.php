<?php

namespace App\View\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class DataWizController extends AbstractController
{
    abstract public function indexAction();
}
