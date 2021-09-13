<?php


namespace App\View\Controller;


use App\Crud\Crudable;
use App\Domain\Model\Filemanagement\AdditionalMaterial;
use App\Io\Formats\Csv\CsvImportable;
use App\Questionnaire\Questionnairable;
use League\Flysystem\Filesystem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/filemanagement", name="File-")
 * @IsGranted("ROLE_USER")
 *
 * Class FileManagementController
 * @package App\View\Controller
 */
class FileManagementController extends DataWizController
{
    private $filesystem;
    private $questionnaire;
    private CsvImportable $csvImportable;

    public function __construct(
        Crudable $crud,
        UrlGeneratorInterface $urlGenerator,
        Filesystem $filesystem,
        Questionnairable $questionnaire,
        CsvImportable $csvImportable
    ) {
        parent::__construct($crud, $urlGenerator);
        $this->filesystem = $filesystem;
        $this->questionnaire = $questionnaire;
        $this->csvImportable = $csvImportable;
    }

    private function deleteUpload($pathOfFile, $entityOfFile): bool
    {
        if ($this->filesystem->has($pathOfFile)) {
            $this->filesystem->delete($pathOfFile);
        }
        $this->crud->delete($entityOfFile);

        return !$this->filesystem->has($pathOfFile);
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
        /** @var AdditionalMaterial $entityForDeletion */
        $entityForDeletion = $this->getEntityAtChange($uuid, AdditionalMaterial::class);
        $experimentId = $entityForDeletion->getExperiment()->getId();
        $success = $this->deleteUpload($entityForDeletion->getStorageName(), $entityForDeletion);
        if ($success) {
            return new RedirectResponse($this->urlGenerator->generate('Study-materials', ['uuid' => $experimentId]));
        } else {
            return new Response('This was not planned', 500);
        }
    }

    /**
     * @Route("/{uuid}/details", name="details")
     *
     * @param string $uuid
     * @param Request $request
     * @return Response
     */
    public function materialDetailsAction(string $uuid, Request $request)
    {
        $entityAtChange = $this->getEntityAtChange($uuid, AdditionalMaterial::class);
        $experimentOfTheFile = $entityAtChange->getExperiment();

        $form = $this->questionnaire->askAndHandle(
            $entityAtChange,
            'save',
            $request
        );

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->crud->update($entityAtChange);
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
     * @Route("/preview/dataset/{fileId}", name="preview-dataset")
     *
     * @param string $fileId
     * @param Request $request
     * @return JsonResponse
     */
    public function importDatasetAction(string $fileId, Request $request): JsonResponse
    {
        $delimiter = $request->get('dataset-import-delimiter') ?? ",";
        $escape = $request->get('dataset-import-escape') ?? "double";
        $headerRows = filter_var($request->get('dataset-import-header-rows'), FILTER_VALIDATE_INT) ?? 0;
        $data = $this->csvImportable->csvToArray($fileId, $delimiter, $escape, $headerRows);

        return new JsonResponse($data, $data ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function getEntityAtChange(string $uuid, string $className)
    {
        return $this->crud->readById($className, $uuid);
    }


}