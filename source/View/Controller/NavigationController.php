<?php


namespace App\View\Controller;


use App\Domain\Model\Study\Experiment;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavigationController extends DataWizController
{
    public function sidebarNavigationAction(Request $request): Response
    {
        $uuid = $request->get('uuid'); // magic string refer to the name of your slug :)

        return $this->render('Components/_navigationSidebar.html.twig', [
            'experiment' => $this->getEntityAtChange($uuid)
        ]);
    }

    public function savebarNavigationAction(Request $request,
                                            string $prevUrl, string $prevTitle,
                                            string $nextUrl, string $nextTitle,
                                            ?FormView $form): Response
    {
        $uuid = $request->get('uuid'); // still a magic strings

        return $this->render('Components/_navigationSavebar.html.twig', [
            'experiment' => $this->getEntityAtChange($uuid),
            'prevUrl' => $this->urlGenerator->generate($prevUrl, ['uuid' => $uuid]),
            'prevTitle' => $prevTitle,
            'nextUrl' => $this->urlGenerator->generate($nextUrl, ['uuid' => $uuid]),
            'nextTitle'=> $nextTitle,
            'form' => $form
        ]);
    }

    protected function getEntityAtChange(string $uuid, string $className = Experiment::class)
    {
        return $this->crud->readById($className, $uuid);
    }
}