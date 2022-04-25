<?php

namespace App\View\Controller;

use App\Domain\Access\Study\ExperimentRepository;
use App\Domain\Form\UserDetailForm;
use App\Domain\Model\Administration\DataWizUser;
use App\Domain\Model\Study\Experiment;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
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
    private LoggerInterface $logger;
    private ExperimentRepository $experimentRepository;

    /**
     * @param EntityManagerInterface $em
     * @param LoggerInterface $logger
     * @param ExperimentRepository $experimentRepository
     */
    public function __construct(EntityManagerInterface $em, LoggerInterface $logger, ExperimentRepository $experimentRepository)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->experimentRepository = $experimentRepository;
    }

    /**
     * @Route(
     *     "/admin/dashboard",
     *      name="admin_dashboard"
     * )
     *
     * @return Response
     */
    public function dashboard(): Response
    {
        $this->logger->debug("AdministrationController::dashboard: Enter");

        return $this->render('Pages/Administration/admin/dashboard.html.twig');
    }

    /**
     * @Route(
     *     "/admin/user",
     *     name="admin_dashboard_user"
     * )
     *
     * @param Request $request
     * @return Response
     */
    public function listUser(Request $request): Response
    {
        $this->logger->debug("AdministrationController::listUser: Enter");

        $q = $request->get('q', '');
        $limit = intval($request->get('limit', 20));
        $page = intval($request->get('page', 0));
        $sort = $request->get('sort', 'lastname;'.Criteria::ASC);
        $sortArray = preg_split('/;/', $sort);
        if ($sortArray == null || sizeof($sortArray) < 2) {
            $sortArray = ['lastname', Criteria::ASC];
        }
        $user = $this->em->getRepository(DataWizUser::class)->findBy([], [$sortArray[0] => $sortArray[1]], $limit, $page * $limit);
        $count = $this->em->getRepository(DataWizUser::class)->count([]);


        return $this->render(
            'Pages/Administration/admin/user.html.twig',
            [
                "user" => $user,
                "pagination" => [
                    'q' => $q,
                    'maxItems' => $count,
                    'maxPages' => intval(ceil($count / $limit)),
                    'limit' => $limit,
                    'page' => $page,
                    'sort' => $sort,
                ],
            ]
        );
    }

    /**
     * @Route(
     *     "/admin/user/{uid}",
     *      name="admin_dashboard_user_edit"
     * )
     *
     * @param Request $request
     * @param string $uid
     * @return Response
     */
    public function editUserDetails(Request $request, string $uid): Response
    {
        $this->logger->debug("AdministrationController::editUserDetails: Enter with uuid: $uid");

        $user = $this->em->getRepository(DataWizUser::class)->find($uid);
        $form = $this->createForm(UserDetailForm::class, $user, ['allow_edit_roles' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('admin_dashboard_user');
        }

        return $this->render("Pages/Administration/admin/user_profile.html.twig", [
            'adminEdit' => true,
            'userForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/studies", name="admin_dashboard_studies")
     *
     * @param Request $request
     * @return Response
     */
    public function listStudies(Request $request): Response
    {
        $this->logger->debug("AdministrationController::listStudies: Enter");

        return $this->render(
            'Pages/Administration/admin/studies.html.twig',
            [
                "studies" => $this->em->getRepository(Experiment::class)->findAll(),
            ]
        );
    }
}
