<?php

namespace App\Entity\DataManagementPlan;

use App\Entity\Administration\UuidEntity;
use App\Enum\YesNo;
use App\Repository\DataManagementPlan\DmpEthicalLegalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'dmp_ethical_legal')]
#[ORM\Entity(repositoryClass: DmpEthicalLegalRepository::class)]
class DmpEthicalLegal extends UuidEntity
{
    #[ORM\OneToOne(inversedBy: 'ethicalLegal', cascade: ['persist', 'remove'])]
    protected ?DataManagementPlan $dataManagementPlan = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ethicalReview = null;

    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $informedConsent = null;

    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $informedConsentDataSharing = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $noInformedConsentReason = null;

    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $personalData = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $personalDataProtectionMeasures = null;

    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $commercialSensitiveData = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commercialDataProtectionMeasures = null;

    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $copyright = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $copyrightLicenses = null;

    #[ORM\Column(length: 255, nullable: true, enumType: YesNo::class)]
    private ?YesNo $thirdPartyRights = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $thirdPartyLicenses = null;

    public function getDataManagementPlan(): ?DataManagementPlan
    {
        return $this->dataManagementPlan;
    }

    public function setDataManagementPlan(?DataManagementPlan $dataManagementPlan): static
    {
        $this->dataManagementPlan = $dataManagementPlan;

        return $this;
    }

    public function getEthicalReview(): ?string
    {
        return $this->ethicalReview;
    }

    public function setEthicalReview(?string $ethicalReview): static
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

    public function getInformedConsentDataSharing(): ?YesNo
    {
        return $this->informedConsentDataSharing;
    }

    public function setInformedConsentDataSharing(?YesNo $informedConsentDataSharing): static
    {
        $this->informedConsentDataSharing = $informedConsentDataSharing;

        return $this;
    }

    public function getNoInformedConsentReason(): ?string
    {
        return $this->noInformedConsentReason;
    }

    public function setNoInformedConsentReason(?string $noInformedConsentReason): static
    {
        $this->noInformedConsentReason = $noInformedConsentReason;

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

    public function getPersonalDataProtectionMeasures(): ?string
    {
        return $this->personalDataProtectionMeasures;
    }

    public function setPersonalDataProtectionMeasures(?string $personalDataProtectionMeasures): static
    {
        $this->personalDataProtectionMeasures = $personalDataProtectionMeasures;

        return $this;
    }

    public function getCommercialSensitiveData(): ?YesNo
    {
        return $this->commercialSensitiveData;
    }

    public function setCommercialSensitiveData(?YesNo $commercialSensitiveData): static
    {
        $this->commercialSensitiveData = $commercialSensitiveData;

        return $this;
    }

    public function getCommercialDataProtectionMeasures(): ?string
    {
        return $this->commercialDataProtectionMeasures;
    }

    public function setCommercialDataProtectionMeasures(?string $commercialDataProtectionMeasures): static
    {
        $this->commercialDataProtectionMeasures = $commercialDataProtectionMeasures;

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
