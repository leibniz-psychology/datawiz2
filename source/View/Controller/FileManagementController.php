<?php


namespace App\View\Controller;


use App\Domain\Model\Codebook\DatasetVariables;
use App\Domain\Model\Filemanagement\AdditionalMaterial;
use App\Domain\Model\Filemanagement\Dataset;
use App\Io\Formats\Csv\CsvImportable;
use App\Questionnaire\Questionnairable;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/filemanagement", name="File-")
 * @IsGranted("ROLE_USER")
 *
 * Class FileManagementController
 * @package App\View\Controller
 */
class FileManagementController extends AbstractController
{
    private Filesystem $filesystem;
    private Questionnairable $questionnaire;
    private CsvImportable $csvImportable;
    private EntityManagerInterface $em;
    private LoggerInterface $logger;

    /**
     * @param Filesystem $filesystem
     * @param Questionnairable $questionnaire
     * @param CsvImportable $csvImportable
     * @param EntityManagerInterface $em
     * @param LoggerInterface $logger
     */
    public function __construct(
        Filesystem $filesystem,
        Questionnairable $questionnaire,
        CsvImportable $csvImportable,
        EntityManagerInterface $em,
        LoggerInterface $logger
    ) {
        $this->filesystem = $filesystem;
        $this->questionnaire = $questionnaire;
        $this->csvImportable = $csvImportable;
        $this->em = $em;
        $this->logger = $logger;
    }


    /**
     * @Route("/delete/{uuid}/material", name="deletion")
     *
     * @param string $uuid
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function deleteMaterialCall(string $uuid, Request $request)
    {
        $this->logger->debug("Enter FileManagementController::deleteMaterialCall with [UUID: $uuid]");
        $entityForDeletion = $this->em->find(AdditionalMaterial::class, $uuid);
        $experimentId = $entityForDeletion->getExperiment()->getId();

        //$success = $this->deleteUpload($entityForDeletion);
        return $this->redirectToRoute('Study-materials', ['uuid' => $experimentId]);
    }

    /**
     * @Route("/{uuid}/details", name="details")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function materialDetailsAction(string $uuid, Request $request): Response
    {
        $this->logger->debug("Enter FileManagementController::materialDetailsAction with [UUID: $uuid]");
        $entityAtChange = $this->em->find(AdditionalMaterial::class, $uuid);
        $experimentOfTheFile = $entityAtChange->getExperiment();
        $form = $this->questionnaire->askAndHandle(
            $entityAtChange,
            'save',
            $request
        );
        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->em->persist($entityAtChange);
            $this->em->flush();
        }
        return $this->render(
            'Pages/FileManagement/materialDetails.html.twig',
            [
                'form' => $form->createView(),
                'file' => $entityAtChange,
                'experiment' => $experimentOfTheFile,
            ]
        );
    }

    /**
     * @Route("/preview/csv/{fileId}", name="preview-dataset")
     *
     * @param string $fileId
     * @param Request $request
     * @return JsonResponse
     */
    public function previewCSVAction(string $fileId, Request $request): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::previewCSVAction with [FileId: $fileId]");
        $delimiter = $request->get('dataset-import-delimiter') ?? ",";
        $escape = $request->get('dataset-import-escape') ?? "double";
        $headerRows = filter_var($request->get('dataset-import-header-rows'), FILTER_VALIDATE_INT) ?? 0;
        $file = $this->em->find(Dataset::class, $fileId);
        $data = null;
        if ($file) {
            $data = $this->csvImportable->csvToArray($file->getStorageName(), $delimiter, $escape, $headerRows);
        }

        return new JsonResponse($data, $data ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @Route("/submit/csv/{fileId}", name="submit-dataset")
     *
     * @param string $fileId
     * @param Request $request
     * @return JsonResponse
     */
    public function submitCSVAction(string $fileId, Request $request): JsonResponse
    {
        $this->logger->debug("Enter FileManagementController::submitCSVAction with [FileId: $fileId]");
        $delimiter = $request->get('dataset-import-delimiter') ?? ",";
        $escape = $request->get('dataset-import-escape') ?? "double";
        $headerRows = filter_var($request->get('dataset-import-header-rows'), FILTER_VALIDATE_INT) ?? 0;
        $dataset = $this->em->find(Dataset::class, $fileId);
        $data = null;
        $error = null;
        if ($dataset) {
            $data = $this->csvImportable->csvToArray($dataset->getStorageName(), $delimiter, $escape, $headerRows);
            if ($data && key_exists('header', $data) && is_iterable($data['header']) && sizeof($data['header']) > 0) {
                $varId = 1;
                foreach ($data['header'] as $var) {
                    $dv = new DatasetVariables();
                    $dv->setName($var);
                    $dv->setVarId($varId++);
                    $dv->setDataset($dataset);
                    $this->em->persist($dv);
                }
                $this->em->flush();
            } elseif ($data && key_exists('records', $data) && is_iterable($data['records']) && sizeof($data['records']) > 0) {
                $varId = 1;
                foreach ($data['records'][0] as $ignored) {
                    $dv = new DatasetVariables();
                    $dv->setName("var_$varId");
                    $dv->setVarId($varId++);
                    $dv->setDataset($dataset);
                    $this->em->persist($dv);
                }
                $this->em->flush();
            } else {
                $error = "error.import.csv.codebook.empty";
            }
            if (null == $error && $data && key_exists('records', $data) && is_iterable($data['records']) && sizeof($data['records']) > 0) {
                $this->saveMatrix($data['records'], $dataset->getId());
            } else {
                $error = "error.import.csv.matrix.empty";
            }
        } else {
            $error = "error.import.csv.dataset.empty";
        }
        if (null != $error) {
            $this->deleteDataset($dataset);
        }

        return new JsonResponse(
            null != $error ? $error : $data,
            null != $error ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK
        );
    }

    /**
     * @param array $matrix
     * @param string $datasetId
     */
    private function saveMatrix(array $matrix, string $datasetId)
    {
        try {
            $this->filesystem->write("matrix/$datasetId.json", json_encode($matrix));
        } catch (FileExistsException $e) {
        }
    }

    /**
     * @param Dataset $dataset
     */
    private function deleteDataset(Dataset $dataset): void
    {
        try {
            if ($this->filesystem->has($dataset->getStorageName())) {
                $this->filesystem->delete($dataset->getStorageName());
            }
            if ($this->filesystem->has("matrix/".$dataset->getId().".json")) {
                $this->filesystem->delete("matrix/".$dataset->getId().".json");
            }
            if ($dataset->getCodebook() != null) {
                foreach ($dataset->getCodebook() as $var) {
                    $this->em->remove($var);
                }
            }
            $this->em->remove($dataset);
            $this->em->flush();
        } catch (FileNotFoundException $e) {
        }
    }
}