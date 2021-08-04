<?php


namespace App\View\Controller;


use App\Domain\Model\Study\Experiment;
use App\Review\ReviewDataCollectable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

        $collectable = ReviewDataCollectable::createFrom('Short Name',
            ['1234', 'another value'], function () { return true; }, 'none');

        return $this->render('Pages/Review/index.html.twig', [
            'experimentName' => $entityAtChange->getSettingsMetaDataGroup()->getShortName(),
            'collectable' => $collectable,
        ]);
    }

    public function displayValue(ReviewDataCollectable $dataCollectable) {
        if (is_array($dataCollectable->getDataValue())) {
            $template = 'Components/_reviewArrayValue.html.twig';
        } else {
            $template = 'Components/_reviewSingleValue.html.twig';
        }

        return $this->render($template, [
            'name' => $dataCollectable->getDataName(),
            'data' => $dataCollectable->getDataValue(),
            'condition' => $dataCollectable->getDisplayCondition(),
        ]);
    }

    protected function getEntityAtChange(string $uuid, string $className = Experiment::class): Experiment
    {
        return $this->crud->readById($className, $uuid);
    }
}