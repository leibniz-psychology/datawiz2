<?php


namespace App\View\Controller;



use App\Codebook\MeasureOptionsModell;
use App\Crud\Crudable;
use App\Domain\Model\Codebook\DatasetMetaData;
use App\Codebook\MetaDataExchangeModell;
use App\Codebook\ValuePairModell;
use App\Codebook\VariableModell;
use App\Domain\Model\Study\Experiment;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/codebook", name="Codebook-")
 *
 * Class CodebookController
 * @package App\View\Controller
 */
class CodebookController extends DataWizController
{
    /**
     * @Route("/{uuid}/data", name="dataupdate")
     *
     * @param string $uuid
     * @param Request $request
     * @return JsonResponse
     */
    public function dataUpdateCall(string $uuid, Request $request)
    {
        if ($request->isMethod("POST")) {
            $postedData = $this->convertCodebookFrom($request);

            // test the update with just one entity before wiring the uuid's correctly
            /** @var DatasetMetaData $entityAtChange */
            $entityAtChange = $this->crud->readForAll(DatasetMetaData::class)[0];
            $this->updateDatasetMetaData($entityAtChange, $postedData);
        } else {
            // test the update with just one entity before wiring the uuid's correctly
            /** @var DatasetMetaData $entityAtChange */
            $entityAtChange = $this->crud->readForAll(DatasetMetaData::class)[0];
        }

        $returnDummy = MetaDataExchangeModell::createFrom(
            [VariableModell::createFrom(
                "1", "sex", "geschlecht", "",
                [ ValuePairModell::createFrom("test","1") ],
                [], ""
            )])->getJsonString();

        return JsonResponse::fromJsonString($returnDummy);
    }

    /**
     * @Route("/{uuid}/measures", name="measures")
     *
     * @param string $uuid
     * @return JsonResponse
     */
    public function measuresCall(string $uuid) {
        // search for the codebook entity
        // get experiment id
        // get measures from there
        // create actual MeasureOptionsModell from the data

        $dummyMeasures = MeasureOptionsModell::createFrom(
            array("measurement A", "measurement B", "measurement C"))
            ->getJsonString();

        return JsonResponse::fromJsonString($dummyMeasures);
    }

    private function updateDatasetMetaData(DatasetMetaData $entityAtChange, array $metadataAsArray)
    {
        $entityAtChange->setMetadata($metadataAsArray);
        $this->crud->update($entityAtChange);
    }

    private function convertCodebookFrom(Request $request)
    {
        return json_decode($request->getContent(), true);
    }

    /**
     * @Route("/{uuid}/index", name="index")
     *
     * @param string $uuid
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function codebookIndexAction(string $uuid, Request $request)
    {
        $returnDummy = MetaDataExchangeModell::createFrom(
            [VariableModell::createFrom(
                "1", "sex", "geschlecht", "",
                [ ValuePairModell::createFrom("test","1") ],
                [], ""
            )])->getJsonString();

        $entityAtDisplay = $this->getEntityAtChange($uuid);

        return $this->render('Pages/Codebook/index.html.twig', [
        'codebook' => $entityAtDisplay,
            'dummy' => $returnDummy
    ]);

    }

    protected function getEntityAtChange(string $uuid, string $className = DatasetMetaData::class)
    {
        /**
         * TODO: This logic should live in the crud service and should be refactor into it's own interface
         */
        // will not work with a proper relation to an experiment - refactor needed
        $entityAtChange = $this->crud->readById($className, $uuid);
        if ($entityAtChange === null) {
            $entityAtChange = DatasetMetaData::createEmptyCode();
            $this->crud->update($entityAtChange);
        }

        return $entityAtChange;
    }
}