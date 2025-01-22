<?php

namespace App\Controller;

use App\Entity\Study\Experiment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class ReviewController extends AbstractController
{
    #[Route(path: 'review/{id}', name: 'Study-review', methods: ['GET'])]
    public function review(Experiment $experiment): Response
    {
        $this->denyAccessUnlessGranted('REVIEW', $experiment);

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
}
