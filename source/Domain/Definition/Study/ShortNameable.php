<?php

namespace App\Domain\Definition\Study;

use App\Domain\Definition\MetaDataDictionary;
use Doctrine\ORM\Mapping as ORM;

trait ShortNameable
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shortName;

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(string $newShortName): void
    {
        $this->shortName = $newShortName;
    }

    public function retrieveShortName() {
        return $this->getShortName();
    }
}
