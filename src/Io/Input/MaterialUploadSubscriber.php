<?php

namespace App\Io\Input;

use App\Entity\FileManagement\AdditionalMaterial;
use App\Entity\Study\Experiment;
use Doctrine\ORM\EntityManagerInterface;
use Oneup\UploaderBundle\Event\PostUploadEvent;
use Oneup\UploaderBundle\UploadEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MaterialUploadSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UploadEvents::postUpload('materials') => ['onMaterialPostUpload'],
        ];
    }

    /**
     * Every time a file is uploaded we want to save the metadata about this file.
     */
    public function onMaterialPostUpload(PostUploadEvent $event)
    {
        $experiment = $this->em->getRepository(Experiment::class)->find($event->getRequest()->get('studyId'));
        $entity = AdditionalMaterial::createMaterial(
            $event->getRequest()->get('originalFilename'),
            $event->getFile()->getBasename(),
            $event->getFile()->getSize(),
            $event->getFile()->getMimeType(),
            $experiment
        );
        $this->em->persist($entity);
        $this->em->flush();
    }
}
