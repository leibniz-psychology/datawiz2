<?php
/**
 * This class provides the short name metadata.
 */

namespace App\Domain\Model;

use App\Domain\Access\StudySettingsMetaDataRepository;
use App\Domain\Definition\Study\ShortNameable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudySettingsMetaDataRepository::class)
 */
class StudySettingsMetaDataGroup extends DataWizMetaDataGroup implements ShortNameable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shortName;

    public function getId()
    {
        return $this->id;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(string $newShortName): void
    {
        $this->shortName = $newShortName;
    }
}
