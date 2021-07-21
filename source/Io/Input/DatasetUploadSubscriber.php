<?php


namespace App\Io\Input;


use App\Api\Spss\SpssApiClient;
use App\Crud\Crudable;
use App\Domain\Model\Filemanagement\OriginalDataset;
use App\Domain\Model\Study\Experiment;
use App\Io\Formats\Csv\CsvImportable;
use Oneup\UploaderBundle\Event\PostUploadEvent;
use Oneup\UploaderBundle\UploadEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DatasetUploadSubscriber implements EventSubscriberInterface
{
    private Crudable $crud;
    private SpssApiClient $spssApiClient;
    private CsvImportable $csvImportable;

    /**
     * DatasetUploadSubscriber constructor.
     * @param Crudable $crud
     * @param SpssApiClient $spssApiClient
     * @param CsvImportable $csvImportable
     */
    public function __construct(Crudable $crud, SpssApiClient $spssApiClient, CsvImportable $csvImportable)
    {
        $this->crud = $crud;
        $this->spssApiClient = $spssApiClient;
        $this->csvImportable = $csvImportable;
    }


    public static function getSubscribedEvents()
    {
        return [
            UploadEvents::postUpload('datasets') => ['onDatasetUpload'],
        ];
    }

    public function onDatasetUpload(PostUploadEvent $event)
    {
        $experiment = $this->crud->readById(Experiment::class, $event->getRequest()->get('studyId'));
        if (null !== $event->getFile()) {
            switch ($event->getFile()->getExtension()) {
                case 'sav':
                    $data = $this->spssApiClient->savToArray($event);
                    break;
                case 'csv':
                case 'tsv':

                    break;
            }
            $dataset = OriginalDataset::createDataset(
                $event->getRequest()->get('originalFilename'),
                $event->getFile()->getBasename(),
                $experiment
            );
            $this->crud->update($dataset);
            $response = $event->getResponse();
            $response->addToOffset(['fileId' => $event->getFile()->getBasename()], ["flySystem"]);
        }
    }

}