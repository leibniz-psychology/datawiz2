<?php

declare(strict_types=1);

namespace App\Service\DataManagementPlan;

use App\Entity\Administration\DataWizUser;
use App\Entity\DataManagementPlan\DataManagementPlan;
use App\Entity\DataManagementPlan\DmpAdministrativeData;
use App\Entity\DataManagementPlan\DmpDataSharing;
use App\Entity\DataManagementPlan\DmpDocumentation;
use App\Entity\DataManagementPlan\DmpResearchData;
use App\Entity\DataManagementPlan\DmpSettings;
use App\Entity\DataManagementPlan\DmpStorageInfrastructure;
use App\Repository\DataManagementPlan\DataManagementPlanRepository;

readonly class DataManagementPlanService
{
    public function __construct(
        private DataManagementPlanRepository $dmpRepository,
    ) {
    }

    public function save(DataManagementPlan $entity): void
    {
        $this->dmpRepository->save($entity);
    }

    public function remove(DataManagementPlan $entity): void
    {
        $this->dmpRepository->remove($entity);
    }

    /**
     * @return DataManagementPlan[]
     */
    public function findByOwner(mixed $user): array
    {
        return $this->dmpRepository->findBy(['owner' => $user]);
    }

    public static function createNewDataManagementPlan(DataWizUser $owner): DataManagementPlan
    {
        $newDataManagementPlan = new DataManagementPlan();
        $newDataManagementPlan->setAdministrativeData(new DmpAdministrativeData());
        $newDataManagementPlan->setResearchData(new DmpResearchData());
        $newDataManagementPlan->setDocumentation(new DmpDocumentation());
        $newDataManagementPlan->setDataSharing(new DmpDataSharing());
        $newDataManagementPlan->setStorageInfrastructure(new DmpStorageInfrastructure());
        $newDataManagementPlan->setSettings(new DmpSettings());
        $newDataManagementPlan->setOwner($owner);

        return $newDataManagementPlan;
    }
}
