<?php


namespace App\View\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class NamingAwareController extends AbstractController
{
    private function getPageNameFromControllerName(): string
    {
        $path = explode('\\', get_called_class());
        $controllerName = array_pop($path);
        $pageName = str_replace("Controller", "", $controllerName);
        $templatePath = "Pages/" . strtolower($pageName) . ".html.twig";
        return $templatePath;
    }

    protected function renderPageByControllerName(array $parameters = [], Response $response = null)
    {
        return $this->render($this->getPageNameFromControllerName(), $parameters, $response);
    }
}