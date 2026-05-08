<?php

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Enum\Study\CreatorCreditRole;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Table(name: 'experiment_basic_creators')]
#[ORM\Entity]
class CreatorMetaDataGroup extends UuidEntity
{
    #[ORM\ManyToOne(inversedBy: 'creators')]
    #[ORM\JoinColumn(name: 'basic_id', referencedColumnName: 'id')]
    protected ?BasicInformationMetaDataGroup $basicInformation = null;
    #[ORM\Column(type: 'text', length: 100, nullable: true)]
    #[SerializedName('given_name')]
    #[Groups('study')]
    private ?string $givenName = null;

    #[ORM\Column(type: 'text', length: 100, nullable: true)]
    #[SerializedName('family_name')]
    #[Groups('study')]
    private ?string $familyName = null;

    #[ORM\Column(type: 'text', length: 250, nullable: true)]
    #[SerializedName('email')]
    #[Groups('study')]
    private ?string $email = null;

    #[ORM\Column(type: 'text', length: 250, nullable: true)]
    #[SerializedName('orcid')]
    #[Groups('study')]
    private ?string $orcid = null;

    #[ORM\Column(type: 'text', length: 1500, nullable: true)]
    #[SerializedName('affiliation')]
    #[Groups('study')]
    private ?string $affiliation = null;

    #[ORM\Column(nullable: true, enumType: CreatorCreditRole::class)]
    #[SerializedName('roles')]
    #[Groups('study')]
    private ?array $creditRoles = null;

    public function isEmpty(): bool
    {
        return empty($this->getFamilyName()) && empty($this->getGivenName()) && empty($this->getEmail());
    }

    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function setGivenName(?string $givenName): void
    {
        $this->givenName = $givenName;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setFamilyName(?string $familyName): void
    {
        $this->familyName = $familyName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getOrcid(): ?string
    {
        return $this->orcid;
    }

    public function setOrcid(?string $orcid): void
    {
        $this->orcid = $orcid;
    }

    public function getAffiliation(): ?string
    {
        return $this->affiliation;
    }

    public function setAffiliation(?string $affiliation): void
    {
        $this->affiliation = $affiliation;
    }

    public function getCreditRoles(): ?array
    {
        if ($this->creditRoles === null) {
            $this->creditRoles = [null];
        }

        return $this->creditRoles;
    }

    public function setCreditRoles(?array $creditRoles): void
    {
        $this->creditRoles = $creditRoles == null ? null : array_values($creditRoles);
    }

    public function getBasicInformation(): BasicInformationMetaDataGroup
    {
        return $this->basicInformation;
    }

    public function setBasicInformation(BasicInformationMetaDataGroup $basicInformation): void
    {
        $this->basicInformation = $basicInformation;
    }
}
