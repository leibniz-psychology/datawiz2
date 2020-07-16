<?php


namespace App\View\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GreetingController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function hello()
    {
        return $this->render('greeting.html.twig');
    }

}