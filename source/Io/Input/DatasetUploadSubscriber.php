<?php


namespace App\Io\Input;


use App\Crud\Crudable;
use App\Domain\Model\Filemanagement\AdditionalMaterial;
use App\Domain\Model\Filemanagement\OriginalDataset;
use App\Domain\Model\Study\Experiment;
use Oneup\UploaderBundle\Event\PostUploadEvent;
use Oneup\UploaderBundle\UploadEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DatasetUploadSubscriber implements EventSubscriberInterface
{
    private $crud;

    public function __construct(Crudable $crud)
    {
        $this->crud = $crud;
    }

    public static function getSubscribedEvents()
    {
        return [
            UploadEvents::postUpload('datasets') => ['onDatasetUpload']
        ];
    }

    public function onDatasetUpload(PostUploadEvent $event) {
        $experiment = $this->crud->readById(Experiment::class, $event->getRequest()->get('studyId'));

        $this->crud->update(
            OriginalDataset::createDataset(
                $event->getRequest()->get('originalFilename'),
                $event->getFile()->getBasename(),
                $experiment
            )
        );
    }

}