<?php


namespace App\View\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class GreetingController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function hello()
    {
        return new Response("Hello structure");
    }

}