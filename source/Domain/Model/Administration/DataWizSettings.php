<?php

namespace App\Domain\Model\Administration;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="settings")
 */
class DataWizSettings extends UuidEntity
{
    /**
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Administration\DataWizUser", inversedBy="datawizSettings")
     */
    private $owner;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    public $dummySetting;
}
