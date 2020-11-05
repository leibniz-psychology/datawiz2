<?php

namespace App\View\Controller;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Dummy controller as demo.
 *
 * Class GreetingController
 */
class GreetingController extends NamingAwareController
{
    /**
     * TODO: Remove this dummy controller as soon as you have homepage.
     *
     * @Route("/index", name="dw_hello", methods="GET")
     */
    public function hello()
    {
        return $this->renderPageByControllerName();
    }
}
