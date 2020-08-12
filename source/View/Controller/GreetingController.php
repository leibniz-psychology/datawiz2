<?php


namespace App\View\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Dummy controller as demo
 *
 * Class GreetingController
 * @package App\View\Controller
 */
class GreetingController extends NamingAwareController
{


    /**
     * TODO: Remove this dummy controller as soon as you have homepage
     * @Route("/index", name="dw_hello", methods="GET")
     */
    public function hello()
    {
       return $this->renderPageByControllerName();
    }

}