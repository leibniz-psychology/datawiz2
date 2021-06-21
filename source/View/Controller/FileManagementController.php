<?php


namespace App\View\Controller;


use App\Crud\Crudable;
use App\Domain\Model\Filemanagement\AdditionalMaterial;
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

    public function __construct(Crudable $crud, UrlGeneratorInterface $urlGenerator, Filesystem $filesystem)
    {
        $this->crud = $crud;
        $this->urlGenerator = $urlGenerator;
        $this->filesystem = $filesystem;
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
        $success = $this->deleteUpload($entityForDeletion->getStorageName(), $entityForDeletion);
        if($success) {
            return new RedirectResponse($this->urlGenerator->generate('Study-overview'));
        }
        else {
            return new Response('This was not planned', 500);
        }
    }

}