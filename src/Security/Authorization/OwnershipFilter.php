<?php

namespace App\Security\Authorization;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class OwnershipFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (!$targetEntity->reflClass->implementsInterface('App\Security\Authorization\Ownable')) {
            return '';
        }

        if ($this->getParameter('currentUserId') === null) {
            return 'true = false';
        }

        return sprintf('%s.owner_id = %s', $targetTableAlias, $this->getParameter('currentUserId'));
    }
}
