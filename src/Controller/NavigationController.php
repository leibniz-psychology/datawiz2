<?php

namespace App\Controller;

use App\Entity\Study\Experiment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class NavigationController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function sidebarNavigation(#[MapRequestPayload] mixed $id, Request $request): Response
    {
        $id = $request->attributes->get('id'); // magic string refer to the name of your slug :)

        return $this->render('components/_navigationSidebar.html.twig', [
            'experiment' => $this->getEntityAtChange($id),
        ]);
    }

    public function savebarNavigation(
        Request $request,
        ?string $prevUrl,
        ?string $prevTitle,
        ?string $nextUrl,
        ?string $nextTitle,
        ?FormView $form
    ): Response {
        $id = $request->attributes->get('id'); // still a magic strings

        return $this->render('components/_navigationSavebar.html.twig', [
            'experiment' => $this->getEntityAtChange($id),
            'prevUrl' => $prevUrl ? $this->generateUrl($prevUrl, ['id' => $id]) : null,
            'prevTitle' => $prevTitle,
            'nextUrl' => $nextUrl ? $this->generateUrl($nextUrl, ['id' => $id]) : null,
            'nextTitle' => $nextTitle,
            'form' => $form,
        ]);
    }

    protected function getEntityAtChange(string $id, string $className = Experiment::class)
    {
        return $this->em->getRepository($className)->find($id);
    }
}
