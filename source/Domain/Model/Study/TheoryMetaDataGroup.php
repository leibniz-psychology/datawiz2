<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\Study\Hypothesiable;
use App\Domain\Definition\Study\Objectivable;
use App\Domain\Model\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class TheoryMetaDataGroup extends UuidEntity implements Objectivable, Hypothesiable
{
}
