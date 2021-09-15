<?php


namespace App\Io\Input;


use App\Crud\Crudable;
use App\Domain\Model\Filemanagement\AdditionalMaterial;
use App\Domain\Model\Study\Experiment;
use Oneup\UploaderBundle\Event\PostUploadEvent;
use Oneup\UploaderBundle\UploadEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MaterialUploadSubscriber implements EventSubscriberInterface
{
    private $crud;

    public function __construct(Crudable $crud)
    {
        $this->crud = $crud;
    }

    public static function getSubscribedEvents()
    {
        return [
            UploadEvents::postUpload('materials') => ['onMaterialPostUpload'],
        ];
    }

    /**
     * @param PostUploadEvent $event
     *
     * Every time a file is uploaded we want to save the metadata about this file
     */
    public function onMaterialPostUpload(PostUploadEvent $event)
    {
        $experiment = $this->crud->readById(Experiment::class, $event->getRequest()->get('studyId'));

        $entity = AdditionalMaterial::createMaterial(
            $event->getRequest()->get('originalFilename'),
            $event->getFile()->getBasename(),
            $experiment
        );
        $this->crud->update($entity);
    }
}