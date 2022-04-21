<?php

namespace App\View\Controller;

use App\Domain\Model\Administration\DataWizUser;
use App\Domain\Model\Study\Experiment;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function dashboard(): Response
    {
        return $this->render('Pages/Administration/admin/dashboard.html.twig');
    }

    /**
     * @Route("/admin/dashboard/user", name="admin_dashboard_user")
     *
     * @return Response
     */
    public function listUser(Request $request): Response
    {
        $q = $request->get('q', '');
        $limit = intval($request->get('limit', 20));
        $page = intval($request->get('page', 0));
        $user = $this->em->getRepository(DataWizUser::class)->findBy([], ['email' => Criteria::ASC], $limit, $page * $limit);
        $count = $this->em->getRepository(DataWizUser::class)->count([]);

        $pagination = [
            'q' => $q,
            'maxItems' => $count,
            'maxPages' => intval(ceil($count / $limit)),
            'limit' => $limit,
            'page' => $page,
        ];

        return $this->render(
            'Pages/Administration/admin/user.html.twig',
            [
                "user" => $user,
                "pagination" => $pagination,
            ]
        );
    }

    /**
     * @Route("/admin/dashboard/studies", name="admin_dashboard_studies")
     *
     * @return Response
     */
    public function listStudies(): Response
    {
        return $this->render(
            'Pages/Administration/admin/studies.html.twig',
            [
                "studies" => $this->em->getRepository(Experiment::class)->findAll(),
            ]
        );
    }
}
