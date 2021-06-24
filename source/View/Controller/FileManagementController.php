<?php


namespace App\View\Controller;


use App\Crud\Crudable;
use App\Domain\Model\Filemanagement\AdditionalMaterial;
use App\Questionnaire\Questionable;
use App\Questionnaire\Questionnairable;
use League\Flysystem\Filesystem;
use Oneup\UploaderBundle\Uploader\Storage\FlysystemStorage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FileManagementController extends AbstractController
{
    private $crud;
    private $urlGenerator;
    private $filesystem;
    private $questionnaire;

    public function __construct(Crudable $crud, UrlGeneratorInterface $urlGenerator, Filesystem $filesystem, Questionnairable $questionnaire)
    {
        $this->crud = $crud;
        $this->urlGenerator = $urlGenerator;
        $this->filesystem = $filesystem;
        $this->questionnaire = $questionnaire;
    }

    private function deleteUpload($pathOfFile, $entityOfFile): bool
    {
        if ($this->filesystem->has($pathOfFile)) {
            $this->filesystem->delete($pathOfFile);
        }
        $this->crud->delete($entityOfFile);

        return ! $this->filesystem->has($pathOfFile);
    }

    public function deleteMaterialCall(string $uuid, Request $request)
    {
        /** @var AdditionalMaterial $entityForDeletion */
        $entityForDeletion = $this->crud->readById(AdditionalMaterial::class, $uuid);
        $experimentId = $entityForDeletion->getExperiment()->getId();
        $success = $this->deleteUpload($entityForDeletion->getStorageName(), $entityForDeletion);
        if($success) {
            return new RedirectResponse($this->urlGenerator->generate('Study-materials', ['uuid' => $experimentId]));
        }
        else {
            return new Response('This was not planned', 500);
        }
    }

    public function materialDetailsAction(string $uuid, Request $request)
    {
        $entityAtChange = $this->crud->readById(AdditionalMaterial::class, $uuid);
        $experimentOfTheFile = $entityAtChange->getExperiment();

        $form = $this->questionnaire->askAndHandle(
            $entityAtChange,
            'save',
            $request);

        if ($this->questionnaire->isSubmittedAndValid($form)) {
            $this->crud->update($entityAtChange);
        }

        return $this->render('Pages/FileManagement/materialDetails.html.twig', [
            'form' => $form->createView(),
            'file' => $entityAtChange,
            'experiment' => $experimentOfTheFile
        ]);
    }
}