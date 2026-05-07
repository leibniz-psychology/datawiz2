<?php

/**
 * This class provides the short name metadata.
 */

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Enum\YesNo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Table(name: 'experiment_ethics')]
#[ORM\Entity(repositoryClass: EthicsMetaDataGroup::class)]
class EthicsMetaDataGroup extends UuidEntity
{
    #[ORM\OneToOne(inversedBy: 'ethicsMetaDataGroup', cascade: ['persist', 'remove'])]
    protected ?Experiment $experiment = null;

    #[ORM\Column(nullable: true, enumType: YesNo::class)]
    #[SerializedName('ethical_review')]
    #[Groups('study')]
    private ?YesNo $ethicalReview = null;

    #[ORM\Column(nullable: true, enumType: YesNo::class)]
    #[SerializedName('informed_consent')]
    #[Groups('study')]
    private ?YesNo $informedConsent = null;

    #[ORM\Column(nullable: true, enumType: YesNo::class)]
    #[SerializedName('personal_data_collection')]
    #[Groups('study')]
    private ?YesNo $personalData = null;

    #[ORM\Column(nullable: true, enumType: YesNo::class)]
    #[SerializedName('copyright')]
    #[Groups('study')]
    private ?YesNo $copyright = null;

    #[ORM\Column(nullable: true, enumType: YesNo::class)]
    #[SerializedName('third_party_rights')]
    #[Groups('study')]
    private ?YesNo $thirdPartyRights = null;

    public function getExperiment(): ?Experiment
    {
        return $this->experiment;
    }

    public function setExperiment(?Experiment $experiment): void
    {
        $this->experiment = $experiment;
    }

    public function getEthicalReview(): ?YesNo
    {
        return $this->ethicalReview;
    }

    public function setEthicalReview(?YesNo $ethicalReview): static
    {
        $this->ethicalReview = $ethicalReview;

        return $this;
    }

    public function getInformedConsent(): ?YesNo
    {
        return $this->informedConsent;
    }

    public function setInformedConsent(?YesNo $informedConsent): static
    {
        $this->informedConsent = $informedConsent;

        return $this;
    }

    public function getPersonalData(): ?YesNo
    {
        return $this->personalData;
    }

    public function setPersonalData(?YesNo $personalData): static
    {
        $this->personalData = $personalData;

        return $this;
    }

    public function getCopyright(): ?YesNo
    {
        return $this->copyright;
    }

    public function setCopyright(?YesNo $copyright): static
    {
        $this->copyright = $copyright;

        return $this;
    }

    public function getThirdPartyRights(): ?YesNo
    {
        return $this->thirdPartyRights;
    }

    public function setThirdPartyRights(?YesNo $thirdPartyRights): static
    {
        $this->thirdPartyRights = $thirdPartyRights;

        return $this;
    }
}
