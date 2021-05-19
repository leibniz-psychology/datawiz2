<?php


namespace App\Io\Input;


use App\Crud\Crudable;
use App\Domain\Model\Filemanagement\AdditionalMaterial;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Oneup\UploaderBundle\Event\PostUploadEvent;
use Oneup\UploaderBundle\Event\PreUploadEvent;
use Oneup\UploaderBundle\UploadEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MaterialUploadSubscriber implements EventSubscriberInterface
{
    private $crud;

    /**
     * @var AdditionalMaterial
     */
    private $currentUpload;

    public function __construct(Crudable $crud)
    {
        $this->crud = $crud;
    }

    public static function getSubscribedEvents()
    {
        return [
            UploadEvents::postUpload('materials') => ['onMaterialPostUpload']
        ];
    }

    // now the renaming is done - attention to use the SAME file again
    public function onMaterialPostUpload(PostUploadEvent $event) {
        $this->crud->update(
            AdditionalMaterial::createMaterial(
                $event->getRequest()->get('originalFilename'),
                $event->getFile()->getBasename()
            )
        );
    }
}