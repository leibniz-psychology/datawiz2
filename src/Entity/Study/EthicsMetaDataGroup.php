<?php

/**
 * This class provides the short name metadata.
 */

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Enum\Study\SharingLevel;
use App\Enum\YesNo;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('ethical_review_description')]
    #[Groups('study')]
    private ?string $ethicalReviewDescription = null;

    #[ORM\Column(nullable: true, enumType: YesNo::class)]
    #[SerializedName('informed_consent')]
    #[Groups('study')]
    private ?YesNo $informedConsent = null;

    #[ORM\Column(nullable: true, enumType: YesNo::class)]
    #[SerializedName('data_sharing_provision')]
    #[Groups('study')]
    private ?YesNo $dataSharing = null;

    #[ORM\Column(nullable: true, enumType: SharingLevel::class)]
    #[SerializedName('data_sharing_level')]
    #[Groups('study')]
    private ?SharingLevel $dataSharingLevel = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('data_sharing_infrastructure')]
    #[Groups('study')]
    private ?string $dataSharingInfrastructure = null;

    #[ORM\Column(nullable: true, enumType: YesNo::class)]
    #[SerializedName('personal_data_collection')]
    #[Groups('study')]
    private ?YesNo $personalData = null;

    #[ORM\Column(nullable: true, enumType: YesNo::class)]
    #[SerializedName('copyright')]
    #[Groups('study')]
    private ?YesNo $copyright = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('copyright_licenses')]
    #[Groups('study')]
    private ?string $copyrightLicenses = null;

    #[ORM\Column(nullable: true, enumType: YesNo::class)]
    #[SerializedName('third_party_rights')]
    #[Groups('study')]
    private ?YesNo $thirdPartyRights = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('third_party_licenses')]
    #[Groups('study')]
    private ?string $thirdPartyLicenses = null;

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

    public function getEthicalReviewDescription(): ?string
    {
        return $this->ethicalReviewDescription;
    }

    public function setEthicalReviewDescription(?string $ethicalReviewDescription): static
    {
        $this->ethicalReviewDescription = $ethicalReviewDescription;

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

    public function getDataSharing(): ?YesNo
    {
        return $this->dataSharing;
    }

    public function setDataSharing(?YesNo $dataSharing): static
    {
        $this->dataSharing = $dataSharing;

        return $this;
    }

    public function getDataSharingLevel(): ?SharingLevel
    {
        return $this->dataSharingLevel;
    }

    public function setDataSharingLevel(?SharingLevel $dataSharingLevel): static
    {
        $this->dataSharingLevel = $dataSharingLevel;

        return $this;
    }

    public function getDataSharingInfrastructure(): ?string
    {
        return $this->dataSharingInfrastructure;
    }

    public function setDataSharingInfrastructure(?string $dataSharingInfrastructure): static
    {
        $this->dataSharingInfrastructure = $dataSharingInfrastructure;

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

    public function getCopyrightLicenses(): ?string
    {
        return $this->copyrightLicenses;
    }

    public function setCopyrightLicenses(?string $copyrightLicenses): static
    {
        $this->copyrightLicenses = $copyrightLicenses;

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

    public function getThirdPartyLicenses(): ?string
    {
        return $this->thirdPartyLicenses;
    }

    public function setThirdPartyLicenses(?string $thirdPartyLicenses): static
    {
        $this->thirdPartyLicenses = $thirdPartyLicenses;

        return $this;
    }
}
