<?php


namespace App\View\Controller;


use App\Domain\Model\Study\Experiment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavigationController extends DataWizController
{
    public function sidebarNavigationAction(Request $request): Response
    {
        $uuid = $request->get('uuid'); // more magic strings :)

        return $this->render('Components/_navigationSidebar.html.twig', [
            'experiment' => $this->getEntityAtChange($uuid)
        ]);
    }

    protected function getEntityAtChange(string $uuid, string $className = Experiment::class)
    {
        return $this->crud->readById($className, $uuid);
    }
}