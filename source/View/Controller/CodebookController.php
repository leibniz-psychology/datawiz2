<?php


namespace App\View\Controller;



use App\Crud\Crudable;
use App\Domain\Model\Codebook\DatasetMetaData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CodebookController extends DataWizController
{
    private $crud;

    public function __construct(Crudable $crud)
    {
        $this->crud = $crud;
    }

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

        return new JsonResponse(
            $entityAtChange->getMetadata()
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
        $entityAtDisplay = $this->getCodebookForUuid($uuid);

        return $this->render('Pages/Codebook/index.html.twig', [
        'codebook' => $entityAtDisplay,
    ]);

    }

    private function getCodebookForUuid(string $uuid): DatasetMetaData
    {
        /**
         * TODO: This logic should live in the crud service and should be refactor into it's own interface
         */
        // will not work with a proper relation to an experiment - refactor needed
        $entityAtChange = $this->crud->readById(DatasetMetaData::class, $uuid);
        if ($entityAtChange === null) {
            $entityAtChange = DatasetMetaData::createEmptyCode();
            $this->crud->update($entityAtChange);
        }

        return $entityAtChange;
    }

}