<?php

namespace App\View\Controller;

use App\Domain\Model\Study\Experiment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NavigationController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function sidebarNavigationAction(Request $request): Response
    {
        $uuid = $request->get('uuid'); // magic string refer to the name of your slug :)

        return $this->render('components/_navigationSidebar.html.twig', [
            'experiment' => $this->getEntityAtChange($uuid),
        ]);
    }

    public function savebarNavigationAction(
        Request $request,
        ?string $prevUrl,
        ?string $prevTitle,
        ?string $nextUrl,
        ?string $nextTitle,
        ?FormView $form
    ): Response {
        $uuid = $request->get('uuid'); // still a magic strings

        return $this->render('components/_navigationSavebar.html.twig', [
            'experiment' => $this->getEntityAtChange($uuid),
            'prevUrl' => $prevUrl ? $this->generateUrl($prevUrl, ['uuid' => $uuid]) : null,
            'prevTitle' => $prevTitle,
            'nextUrl' => $nextUrl ? $this->generateUrl($nextUrl, ['uuid' => $uuid]) : null,
            'nextTitle' => $nextTitle,
            'form' => $form,
        ]);
    }

    protected function getEntityAtChange(string $uuid, string $className = Experiment::class)
    {
        return $this->em->getRepository($className)->find($uuid);
    }
}
