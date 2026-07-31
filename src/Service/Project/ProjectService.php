<?php

declare(strict_types=1);

namespace App\Service\Project;

use App\Entity\Administration\DataWizUser;
use App\Entity\Project\Project;
use App\Entity\Project\ProjectAdministrativeData;
use App\Entity\Project\ProjectSettings;
use App\Repository\Project\ProjectRepository;

readonly class ProjectService
{
    public function __construct(
        private ProjectRepository $projectRepository,
    ) {
    }

    public function save(Project $entity): void
    {
        $this->projectRepository->save($entity);
    }

    public function remove(Project $entity): void
    {
        $this->projectRepository->remove($entity);
    }

    /**
     * @return Project[]
     */
    public function findByOwner(mixed $user): array
    {
        return $this->projectRepository->findBy(['owner' => $user]);
    }

    public static function createNewProject(DataWizUser $owner): Project
    {
        $newProject = new Project();
        $newProject->setAdministrativeData(new ProjectAdministrativeData());
        $newProject->setSettings(new ProjectSettings());
        $newProject->setOwner($owner);

        return $newProject;
    }
}
