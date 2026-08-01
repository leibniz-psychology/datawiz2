<?php

declare(strict_types=1);

namespace App\Service\Io\Input;

use App\Entity\Project\Project;
use App\Entity\Project\ProjectMaterial;
use Doctrine\ORM\EntityManagerInterface;
use Oneup\UploaderBundle\Event\PostUploadEvent;
use Oneup\UploaderBundle\UploadEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class ProjectMaterialUploadSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UploadEvents::postUpload('project_materials') => ['onProjectMaterialPostUpload'],
        ];
    }

    /**
     * Every time a file is uploaded we want to save the metadata about this file.
     */
    public function onProjectMaterialPostUpload(PostUploadEvent $event)
    {
        $project = $this->em->getRepository(Project::class)->find($event->getRequest()->request->get('projectId'));
        $entity = ProjectMaterial::createMaterial(
            $event->getRequest()->request->get('originalFilename'),
            $event->getFile()->getBasename(),
            $event->getFile()->getSize(),
            $event->getFile()->getMimeType(),
            $project
        );
        $this->em->persist($entity);
        $this->em->flush();
    }
}
