<?php

namespace App\Controller;

use App\Entity\Administration\DataWizUser;
use App\Entity\Study\Experiment;
use App\Form\UserDetailForm;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class AdministrationController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly LoggerInterface $logger
    ) {}

    #[Route(path: '/admin/user', name: 'admin_user', methods: ['GET'])]
    public function listUser(): Response
    {
        $this->logger->debug('AdministrationController::listUser: Enter');

        return $this->render(
            'pages/administration/admin/user.html.twig',
            [
                'user' => $this->em->getRepository(DataWizUser::class)->findAll(),
            ]
        );
    }

    #[Route(path: '/admin/user/{id}', name: 'admin_user_edit', methods: ['GET', 'POST'])]
    public function editUserDetails(DataWizUser $user, Request $request): Response
    {
        $this->logger->debug("AdministrationController::editUserDetails: Enter with uuid: {$user->getId()}");

        $form = $this->createForm(UserDetailForm::class, $user, ['allow_edit_roles' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('admin_user');
        }

        return $this->render('pages/administration/admin/user_profile.html.twig', [
            'adminEdit' => true,
            'userForm' => $form,
        ]);
    }

    #[Route(path: '/admin/studies', name: 'admin_studies', methods: ['GET'])]
    public function listStudies(): Response
    {
        $this->logger->debug('AdministrationController::listStudies: Enter');

        return $this->render(
            'pages/administration/admin/studies.html.twig',
            [
                'studies' => $this->em->getRepository(Experiment::class)->findAll(),
                'backPath' => $this->generateUrl('moderation_dashboard'),
            ]
        );
    }

    #[Route(path: '/admin/user/{id}/studies', name: 'admin_user_studies', methods: ['GET'])]
    public function listStudiesForUser(DataWizUser $owner): Response
    {
        $this->logger->debug('AdministrationController::listStudies: Enter');

        return $this->render(
            'pages/administration/admin/studies.html.twig',
            [
                'studies' => $this->em->getRepository(Experiment::class)->findBy(['owner' => $owner]),
                'backPath' => $this->generateUrl('admin_user'),
            ]
        );
    }
}
