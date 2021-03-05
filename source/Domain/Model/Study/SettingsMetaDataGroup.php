<?php
/**
 * This class provides the short name metadata.
 */

namespace App\Domain\Model\Study;

use App\Domain\Access\Study\SettingsMetaDataRepository;
use App\Domain\Definition\Study\ShortNameable;
use App\Domain\Model\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettingsMetaDataRepository::class)
 */
class SettingsMetaDataGroup extends UuidEntity implements ShortNameable
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
}
