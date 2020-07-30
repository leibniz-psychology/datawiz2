<?php


namespace App\View\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GreetingController extends NamingAwareController
{
    /**
     * @Route("/")
     */
    public function hello()
    {
        return $this->renderPageByControllerName();
    }
}