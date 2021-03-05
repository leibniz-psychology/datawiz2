<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\Study\Abstractable;
use App\Domain\Definition\Study\Authorable;
use App\Domain\Definition\Study\Titleable;
use App\Domain\Model\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class BasicInformationMetaDataGroup extends UuidEntity implements Abstractable, Authorable, Titleable
{
}
