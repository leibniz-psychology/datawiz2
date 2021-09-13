<?php


namespace App\View\Controller;



use App\Codebook\MeasureOptionsModell;
use App\Crud\Crudable;
use App\Domain\Model\Codebook\DatasetMetaData;
use App\Codebook\MetaDataExchangeModell;
use App\Codebook\ValuePairModell;
use App\Codebook\VariableModell;
use App\Domain\Model\Filemanagement\OriginalDataset;
use App\Domain\Model\Study\Experiment;
use phpDocumentor\Reflection\Types\This;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/codebook", name="codebook_")
 * @IsGranted("ROLE_USER")
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
        // test the update with just one entity before wiring the uuid's correctly
        /** @var DatasetMetaData $entityAtChange */
        $entityAtChange = $this->getEntityAtChange($uuid);

        if ($request->isMethod("POST")) {
            $postedData = $this->convertCodebookFrom($request);
            $this->updateDatasetMetaData($entityAtChange, $postedData);
        }

        return JsonResponse::fromJsonString($this->JsonFor($entityAtChange));
    }

    /**
     * @Route("/{uuid}/measures", name="measures")
     *
     * @param string $uuid
     * @return JsonResponse
     */
    public function measuresCall(string $uuid)
    {
        // search for the codebook entity
        // get experiment id
        // get measures from there
        // create actual MeasureOptionsModell from the data

        $dummyMeasures = MeasureOptionsModell::createFrom(
            array("Accuracy of memory (percentage of correct answers)", "Reaction times for keying in the first results (ms)")
        )
            ->getJsonString();

        return JsonResponse::fromJsonString($dummyMeasures);
    }

    private function updateDatasetMetaData(DatasetMetaData $entityAtChange, array $metadataAsArray)
    {
        $entityAtChange->setMetadata($metadataAsArray);
        $this->crud->update($entityAtChange);
    }

    private function JsonFor(DatasetMetaData $codebook) {
        return json_encode($codebook->getMetadata());
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

        $entityAtDisplay = $this->getEntityAtChange($uuid);

        return $this->render('Pages/Codebook/index.html.twig', [
            'codebook' => $entityAtDisplay,
            'dummy' => $this->JsonFor($entityAtDisplay)
        ]);
    }

    protected function getEntityAtChange(string $uuid, string $className = OriginalDataset::class): DatasetMetaData
    {
        /**
         * @var $dataset OriginalDataset
         */
        $dataset = $this->crud->readById($className, $uuid);
        if ($dataset === null) {
            $result = $this->crud->readById(DatasetMetaData::class, $uuid);
        } else {
            $result = $dataset->getCodebook();
        }

        return $result;
    }
}
