<?php


namespace App\View\Controller;


use App\Codebook\MeasureOptionsModell;
use App\Domain\Model\Filemanagement\Dataset;
use App\Domain\Model\Study\MeasureMetaDataGroup;
use Doctrine\Common\Collections\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/{uuid}", name="index")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function codebookIndexAction(string $uuid, Request $request): Response
    {
        return $this->render('Pages/Codebook/index.html.twig', [
            'codebook' => $this->crud->readById(Dataset::class, $uuid),
        ]);
    }

    /**
     * @Route("/{uuid}/data", name="dataupdate")
     *
     * @param string $uuid
     * @param Request $request
     * @return JsonResponse
     */
    public function dataUpdateCall(string $uuid, Request $request): JsonResponse
    {
        $dataset = $this->crud->readById(Dataset::class, $uuid);

        if ($dataset && $request->isMethod("POST")) {
            $postedData = $this->convertCodebookFrom($request);
            //$this->updateDatasetMetaData($entityAtChange, $postedData);
        }

        return JsonResponse::fromJsonString($this->parseCodebookToJsonArray($dataset->getCodebook()));
    }

    /**
     * @Route("/{uuid}/measures", name="measures")
     *
     * @param string $uuid
     * @return JsonResponse
     */
    public function createViewMeasuresAction(string $uuid): JsonResponse
    {
        $viewMeasures = null;
        $dataset = $this->em->getRepository(Dataset::class)->find($uuid);
        if ($dataset) {
            $measures = $this->em->getRepository(MeasureMetaDataGroup::class)->findOneBy(['experiment' => $dataset->getExperiment()]);
            if ($measures) {
                $viewMeasures = MeasureOptionsModell::createFrom(
                    $measures->getMeasures()
                )->getJsonString();
            }
        }

        return JsonResponse::fromJsonString($viewMeasures, $viewMeasures != null ? Response::HTTP_OK : Response::HTTP_NO_CONTENT);
    }

    private function updateDatasetMetaData(Collection $codebook, array $metadataAsArray)
    {
        /*$entityAtChange->setMetadata($metadataAsArray);
        $this->crud->update($entityAtChange);*/
    }

    private function parseCodebookToJsonArray(Collection $codebook)
    {
        $jsonCodebook = [];
        foreach ($codebook as $var) {
            $jsonCodebook['variables'][] = [
                "id" => $var->getVarId(),
                "name" => $var->getName() ?? "",
                "label" => $var->getLabel() ?? "",
                "itemText" => $var->getItemText() ?? "",
                "values" => $var->getValues() ?? [
                        [
                            "name" => "",
                            "label" => "",
                        ],
                    ],
                "missings" => $var->getMissings() ?? [
                        [
                            "name" => "",
                            "label" => "",
                        ],
                    ],
                "measure" => $var->getMeasure() ?? "",
                "var_db_id" => $var->getId(),
            ];
        }

        return json_encode($jsonCodebook);
    }

    private function convertCodebookFrom(Request $request)
    {
        return json_decode($request->getContent(), true);
    }


    protected function getEntityAtChange(string $uuid, string $className = Dataset::class)
    {
    }
}
