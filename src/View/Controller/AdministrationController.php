<?php

namespace App\View\Controller;

use App\Domain\Form\UserDetailForm;
use App\Domain\Model\Administration\DataWizUser;
use App\Domain\Model\Study\Experiment;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
class AdministrationController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly LoggerInterface $logger
    )
    {
    }


    #[Route(path: '/admin/user', name: 'admin_user')]
    public function listUser(): Response
    {
        $this->logger->debug("AdministrationController::listUser: Enter");

        return $this->render(
            'Pages/Administration/admin/user.html.twig',
            [
                "user" => $this->em->getRepository(DataWizUser::class)->findAll(),
            ]
        );
    }

    #[Route(path: '/admin/user/{uid}', name: 'admin_user_edit')]
    public function editUserDetails(Request $request, string $uid): Response
    {
        $this->logger->debug("AdministrationController::editUserDetails: Enter with uuid: $uid");

        $user = $this->em->getRepository(DataWizUser::class)->find($uid);
        $form = $this->createForm(UserDetailForm::class, $user, ['allow_edit_roles' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('admin_user');
        }

        return $this->render("Pages/Administration/admin/user_profile.html.twig", [
            'adminEdit' => true,
            'userForm' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/studies', name: 'admin_studies')]
    public function listStudies(): Response
    {
        $this->logger->debug("AdministrationController::listStudies: Enter");

        return $this->render(
            'Pages/Administration/admin/studies.html.twig',
            [
                "studies" => $this->em->getRepository(Experiment::class)->findAll(),
                "backPath" => $this->generateUrl('moderation_dashboard'),
            ]
        );
    }

    #[Route(path: '/admin/user/{uid}/studies', name: 'admin_user_studies')]
    public function listStudiesForUser(string $uid): Response
    {
        $this->logger->debug("AdministrationController::listStudies: Enter");

        return $this->render(
            'Pages/Administration/admin/studies.html.twig',
            [
                "studies" => $this->em->getRepository(Experiment::class)->findBy(['owner' => $this->em->getRepository(DataWizUser::class)->find($uid)]),
                "backPath" => $this->generateUrl('admin_user'),
            ]
        );
    }
}
