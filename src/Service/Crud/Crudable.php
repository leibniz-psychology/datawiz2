<?php

namespace App\Service\Crud;

use App\Entity\FileManagement\AdditionalMaterial;
use App\Entity\FileManagement\Dataset;
use App\Entity\Project\Project;
use App\Entity\Project\ProjectMaterial;
use App\Entity\Study\Experiment;

interface Crudable
{
    public function readById(string $type, $id);

    public function readForAll(string $type): array;

    public function readByCriteria(string $type, array $criteria, ?array $orderBy = null, $limit = null, $offset = null);

    public function update(&$entity): void;

    public function delete($entity): void;

    public function doTransaction(callable $callback);

    public function deleteMaterial(AdditionalMaterial $material): bool;

    public function deleteDataset(Dataset $dataset): bool;

    public function deleteStudy(Experiment $experiment): bool;

    public function saveDatasetMatrix(array $matrix, string $datasetId): bool;

    public function deleteProjectMaterial(ProjectMaterial $material): bool;

    public function deleteProject(Project $project): bool;
}
