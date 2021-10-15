<?php


namespace App\View\Controller;


use App\Domain\Model\Study\Experiment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class ReviewController extends DataWizController
{
    /**
     * @Route("review/{uuid}", name="Study-review")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function reviewAction(string $uuid, Request $request): Response
    {
        $entityAtChange = $this->getEntityAtChange($uuid);

        return $this->render('Pages/Review/index.html.twig', [
            'experimentName' => $entityAtChange->getSettingsMetaDataGroup()->getShortName(),
            'basicInfoReview' => $entityAtChange->getBasicInformationMetaDataGroup()->getReviewCollection(),
            'basicCreatorInfoReview' => $entityAtChange->getBasicInformationMetaDataGroup()->getCreators(),
            'theoryReview' => $entityAtChange->getTheoryMetaDataGroup()->getReviewCollection(),
            'methodReview' => $entityAtChange->getMethodMetaDataGroup()->getReviewCollection(),
            'measureReview' => $entityAtChange->getMeasureMetaDataGroup()->getReviewCollection(),
            'sampleReview' => $entityAtChange->getSampleMetaDataGroup()->getReviewCollection(),
        ]);
    }

    protected function getEntityAtChange(string $uuid, string $className = Experiment::class): Experiment
    {
        return $this->crud->readById($className, $uuid);
    }
}