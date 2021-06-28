<?php


namespace App\View\Controller;



use App\Crud\Crudable;
use App\Domain\Model\Codebook\DatasetMetaData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CodebookController extends DataWizController
{
    private $crud;

    public function __construct(Crudable $crud)
    {
        $this->crud = $crud;
    }

    public function dataUpdateCall(string $uuid, Request $request)
    {
        // get codebook entity or create one
        // extract json from posted request
        // update json
        // return convention to show success
        return new Response('Dummy api - implement me');
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