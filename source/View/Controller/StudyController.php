<?php

namespace App\View\Controller;

use App\Domain\Model\StudySettingsMetaDataGroup;
use App\Questionaire\Forms\StudySettingsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StudyController extends DataWizController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function indexAction(Request $request): Response
    {
        $studySetting = $this->em->getRepository(StudySettingsMetaDataGroup::class)->findAll();

        $form = $this->createForm(StudySettingsType::class, $studySetting[1]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $studySetting = $form->getData();
            $this->em->persist($studySetting);
            $this->em->flush();
        }

        return $this->render('Pages/Studies/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function newAction(): Response
    {
        return $this->render('Pages/Studies/new.html.twig');
    }

    public function documentationAction(): Response
    {
        return $this->render('Pages/Studies/documentation.html.twig');
    }

    public function adminAction(): Response
    {
        return $this->render('Pages/Studies/admin.html.twig');
    }

    public function designAction(): Response
    {
        return $this->render('Pages/Studies/design.html.twig');
    }

    public function theoryAction(): Response
    {
        return $this->render('Pages/Studies/theory.html.twig');
    }

    public function sampleAction(): Response
    {
        return $this->render('Pages/Studies/sample.html.twig');
    }
}
