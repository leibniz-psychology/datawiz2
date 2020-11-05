<?php

namespace App\View\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Additional layer for classic mvc applications
 * Assuming a one template to one controller relationship.
 *
 * Class NamingAwareController
 */
abstract class NamingAwareController extends AbstractController
{
    /**
     * Resolves the template path for calling controller.
     *
     * For GreetingController with "Pages", ".html.twig" and "Controller" as parameter
     * Result: "Pages/greeting.html.twig"
     */
    public function getTemplatePathFromControllerName(string $subdir, string $mimeType, string $suffixCutted): string
    {
        // converts complete namepace App\View\Controller\NameController into array
        $path = explode('\\', get_called_class());
        // get NameController part
        $controllerName = array_pop($path);
        // cut suffix from NameController (commonly 'Controller')
        $pageName = str_replace($suffixCutted, '', $controllerName);
        // create template path $subdir/name$mimeType
        // example Pages/greeting.html.twig
        return $subdir.'/'.strtolower($pageName).$mimeType; // Path to template
    }

    /**
     * Simple convenience method which trims the parameter list of AbstractController->render.
     */
    protected function renderPageByControllerName(array $parameters = [], Response $response = null): Response
    {
        return $this->render(
            $this->getTemplatePathFromControllerName('Pages',
                                            '.html.twig',
                                        'Controller'),
            $parameters,
            $response);
    }
}
