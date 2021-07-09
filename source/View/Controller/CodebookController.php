<?php


namespace App\View\Controller;



use App\Crud\Crudable;
use App\Domain\Model\Codebook\DatasetMetaData;
use App\Codebook\MetaDataExchangeModell;
use App\Codebook\ValuePairModell;
use App\Codebook\VariableModell;
use App\Domain\Model\Study\Experiment;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CodebookController extends DataWizController
{
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

        $returnDummy = \GuzzleHttp\json_encode(MetaDataExchangeModell::createFrom(
            [VariableModell::createFrom(
                "1", "sex", "geschlecht", "",
                [ ValuePairModell::createFrom("test","1") ],
                [], ""
            )]));

        return new JsonResponse(
            $returnDummy
        );
    }

    private function updateDatasetMetaData(DatasetMetaData $entityAtChange, array $metadataAsArray)
    {
        $entityAtChange->setMetadata($metadataAsArray);
        $this->crud->update($entityAtChange);
    }

    private function convertCodebookFrom(Request $request)
    {
        return \GuzzleHttp\json_decode($request->getContent(), true);
    }

    public function codebookIndexAction(string $uuid, Request $request)
    {
        $entityAtDisplay = $this->getEntityAtChange($uuid);

        return $this->render('Pages/Codebook/index.html.twig', [
        'codebook' => $entityAtDisplay,
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