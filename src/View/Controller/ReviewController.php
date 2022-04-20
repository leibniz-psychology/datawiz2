<?php


namespace App\View\Controller;


use App\Domain\Definition\UserRoles;
use App\Domain\Model\Study\Experiment;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class ReviewController extends AbstractController
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
     * @Route("review/{uuid}", name="Study-review")
     *
     * @param string $uuid
     * @return Response
     */
    public function reviewAction(string $uuid): Response
    {
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);

        if (!$this->_checkAccess($experiment)) {
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('Pages/Review/index.html.twig', [
            'experiment' => $experiment,
            'experimentName' => $experiment->getSettingsMetaDataGroup()->getShortName(),
            'basicInfoReview' => $experiment->getBasicInformationMetaDataGroup()->getReviewCollection(),
            'basicCreatorInfoReview' => $experiment->getBasicInformationMetaDataGroup()->getCreators(),
            'theoryReview' => $experiment->getTheoryMetaDataGroup()->getReviewCollection(),
            'methodReview' => $experiment->getMethodMetaDataGroup()->getReviewCollection(),
            'measureReview' => $experiment->getMeasureMetaDataGroup()->getReviewCollection(),
            'sampleReview' => $experiment->getSampleMetaDataGroup()->getReviewCollection(),
        ]);
    }


    private function _checkAccess(Experiment $experiment): bool
    {
        return $this->isGranted(UserRoles::REVIEWER) || $experiment->getOwner() === $this->getUser();
    }
}
