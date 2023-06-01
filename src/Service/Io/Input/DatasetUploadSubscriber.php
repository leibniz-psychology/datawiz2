<?php

namespace App\Service\Io\Input;

use App\Entity\FileManagement\Dataset;
use App\Entity\Study\Experiment;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\UnableToRetrieveMetadata;
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
        if ($event->getFile() == null) {
            return;
        }

        $experiment = $this->em->getRepository(Experiment::class)->find($event->getRequest()->get('studyId'));
        try {
            $mimeType = $event->getFile()->getMimeType();
        } catch (UnableToRetrieveMetadata) {
            // .sav mimetypes cannot be detected by the oneup flysystem, so we get the mimetype from the request
            $mimeType = $event->getRequest()->files->get('file')->getClientMimeType();
        }

        $dataset = Dataset::createDataset(
            $event->getRequest()->get('originalFilename'),
            $event->getFile()->getBasename(),
            $event->getFile()->getSize(),
            $mimeType,
            $experiment
        );
        $this->em->persist($dataset);
        $this->em->flush();
        $response = $event->getResponse();
        $response->addToOffset(['fileId' => $dataset->getId(), 'fileType' => $event->getFile()->getExtension()], ['flySystem']);
    }
}
