<?php

namespace App\Io\Input;

use App\Domain\Model\Filemanagement\Dataset;
use App\Domain\Model\Study\Experiment;
use Doctrine\ORM\EntityManagerInterface;
use Oneup\UploaderBundle\Event\PostUploadEvent;
use Oneup\UploaderBundle\UploadEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DatasetUploadSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UploadEvents::postUpload('datasets') => ['onDatasetUpload'],
        ];
    }

    public function onDatasetUpload(PostUploadEvent $event)
    {
        $experiment = $this->em->getRepository(Experiment::class)->find($event->getRequest()->get('studyId'));
        if ($event->getFile() !== null) {
            $dataset = Dataset::createDataset(
                $event->getRequest()->get('originalFilename'),
                $event->getFile()->getBasename(),
                $event->getFile()->getSize(),
                $event->getFile()->getMimeType(),
                $experiment
            );
            $this->em->persist($dataset);
            $this->em->flush();
            $response = $event->getResponse();
            $response->addToOffset(['fileId' => $dataset->getId(), 'fileType' => $event->getFile()->getExtension()], ['flySystem']);
        }
    }
}
