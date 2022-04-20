<?php

namespace App\View\Controller;

use App\Domain\Model\Administration\DataWizUser;
use App\Domain\Model\Study\Experiment;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdministrationController extends AbstractController
{
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     *
     * @return Response
     */
    public function landingAction(): Response
    {
        return $this->render(
            'Pages/Administration/moderation/dashboard.html.twig',
            [
                "studies" => $this->em->getRepository(Experiment::class)->findAll(),
                "user" => $this->em->getRepository(DataWizUser::class)->findAll(),
            ]
        );
    }
}
