<?php

namespace App\View\Controller;

use App\Domain\Definition\UserRoles;
use App\Domain\Model\Study\Experiment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class ReviewController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Route(path: 'review/{uuid}', name: 'Study-review')]
    public function reviewAction(string $uuid): Response
    {
        $experiment = $this->em->getRepository(Experiment::class)->find($uuid);

        if (!$this->_checkAccess($experiment)) {
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('pages/review/index.html.twig', [
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
