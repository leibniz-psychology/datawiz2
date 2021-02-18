<?php

namespace App\Crud;

interface Crudable
{
    public function readById(string $type, $id);

    public function readForAll(string $type): array;

    public function readByCriteria(string $type, array $criteria,
                                   ?array $orderBy = null, $limit = null,
                                   $offset = null);

    public function update($entity): void;

    public function delete($entity): void;

    public function doTransaction(callable $callback);
}
