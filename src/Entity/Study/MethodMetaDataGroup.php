<?php

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Enum\Study\ControlOperations;
use App\Enum\Study\ExperimentalDesign;
use App\Enum\Study\ExperimentalDetails;
use App\Enum\Study\NonExperimentalDetails;
use App\Enum\Study\ObservationalType;
use App\Enum\Study\ResearchDesign;
use App\Enum\Study\ResearchMethod;
use App\Enum\Study\StudySetting;
use App\Enum\Study\SurveyInstrumentType;
use App\Repository\MethodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Table(name: 'experiment_method')]
#[ORM\Entity(repositoryClass: MethodRepository::class)]
class MethodMetaDataGroup extends UuidEntity
{
    /**
     * One basic Information section has One Experiment.
     */
    #[ORM\OneToOne(inversedBy: 'methodMetaDataGroup', cascade: ['persist', 'remove'])]
    protected ?Experiment $experiment = null;

    #[ORM\Column(nullable: true, enumType: ResearchMethod::class)]
    #[SerializedName('research_design')]
    #[Groups(['study'])]
    private ?ResearchMethod $researchMethod = null;

    #[ORM\Column(nullable: true, enumType: ExperimentalDetails::class)]
    #[SerializedName('experimental_details')]
    #[Groups(['experimental'])]
    private ?ExperimentalDetails $experimentalDetails = null;

    #[ORM\Column(nullable: true, enumType: NonExperimentalDetails::class)]
    #[SerializedName('non_experimental_details')]
    #[Groups(['non_experimental'])]
    private ?NonExperimentalDetails $nonExperimentalDetails = null;

    #[ORM\Column(nullable: true, enumType: ObservationalType::class)]
    #[SerializedName('observational_type')]
    #[Groups(['non_experimental'])]
    private ?ObservationalType $observationalType = null;

    #[ORM\Column(nullable: true, enumType: StudySetting::class)]
    #[SerializedName('setting')]
    #[Groups(['study'])]
    private ?StudySetting $setting = null;

    #[ORM\Column(type: 'text', length: 1500, nullable: true)]
    #[SerializedName('setting_location')]
    #[Groups(['study'])]
    private ?string $settingLocation = null;

    #[ORM\Column(type: 'text', length: 1500, nullable: true)]
    #[SerializedName('manipulations')]
    #[Groups(['experimental'])]
    private ?string $manipulations = null;

    #[ORM\Column(nullable: true, enumType: ExperimentalDesign::class)]
    #[SerializedName('experimental_design')]
    #[Groups(['experimental'])]
    private ?ExperimentalDesign $experimentalDesign = null;

    #[ORM\Column(nullable: true, enumType: ControlOperations::class)]
    #[SerializedName('control_operations')]
    #[Groups(['experimental'])]
    private ?ControlOperations $controlOperations = null;

    #[ORM\Column(type: 'text', length: 1500, nullable: true)]
    #[SerializedName('other_control_operations')]
    #[Groups(['experimental'])]
    private ?string $otherControlOperations = null;

    #[ORM\Column(nullable: true, enumType: ResearchDesign::class)]
    #[SerializedName('research_design')]
    #[Groups(['study'])]
    private ?ResearchDesign $researchDesign = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('research_design_description')]
    #[Groups(['study'])]
    private ?string $researchDesignDescription = null;

    #[ORM\Column(nullable: true, enumType: SurveyInstrumentType::class)]
    #[SerializedName('survey_instrument_type')]
    #[Groups(['non_experimental'])]
    private ?SurveyInstrumentType $surveyInstrumentType = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('treatment_groups')]
    #[Groups(['experimental'])]
    private ?array $treatmentGroups = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('research_method_description')]
    #[Groups(['study'])]
    private ?string $researchMethodDescription = null;

    #[ORM\OneToMany(targetEntity: MeasurementOccasion::class, mappedBy: 'method', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[SerializedName('measurement_occasions')]
    #[Groups('study')]
    private Collection $measurementOccasions;

    #[ORM\OneToMany(targetEntity: MethodConstruct::class, mappedBy: 'method', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[SerializedName('constructs')]
    #[Groups('study')]
    private Collection $constructs;

    #[ORM\OneToMany(targetEntity: MeasurementInstrument::class, mappedBy: 'method', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[SerializedName('measurement_instruments')]
    #[Groups('study')]
    private Collection $measurementInstruments;

    public function __construct()
    {
        $this->measurementOccasions = new ArrayCollection();
        $this->constructs = new ArrayCollection();
        $this->measurementInstruments = new ArrayCollection();
    }

    public function getExperiment(): Experiment
    {
        return $this->experiment;
    }

    public function setExperiment(Experiment $experiment): void
    {
        $this->experiment = $experiment;
    }

    public function getSetting(): ?StudySetting
    {
        return $this->setting;
    }

    public function setSetting(?StudySetting $setting): void
    {
        $this->setting = $setting;
    }

    public function getSettingLocation(): ?string
    {
        return $this->settingLocation;
    }

    public function setSettingLocation(?string $settingLocation): void
    {
        $this->settingLocation = $settingLocation;
    }

    public function getResearchMethod(): ?ResearchMethod
    {
        return $this->researchMethod;
    }

    public function setResearchMethod(?ResearchMethod $researchMethod): void
    {
        $this->researchMethod = $researchMethod;
    }

    public function getExperimentalDetails(): ?ExperimentalDetails
    {
        return $this->experimentalDetails;
    }

    public function setExperimentalDetails(?ExperimentalDetails $experimentalDetails): void
    {
        $this->experimentalDetails = $experimentalDetails;
    }

    public function getNonExperimentalDetails(): ?NonExperimentalDetails
    {
        return $this->nonExperimentalDetails;
    }

    public function setNonExperimentalDetails(?NonExperimentalDetails $nonExperimentalDetails): void
    {
        $this->nonExperimentalDetails = $nonExperimentalDetails;
    }

    public function getObservationalType(): ?ObservationalType
    {
        return $this->observationalType;
    }

    public function setObservationalType(?ObservationalType $observationalType): void
    {
        $this->observationalType = $observationalType;
    }

    public function getManipulations(): ?string
    {
        return $this->manipulations;
    }

    public function setManipulations(?string $manipulations): void
    {
        $this->manipulations = $manipulations;
    }

    public function getExperimentalDesign(): ?ExperimentalDesign
    {
        return $this->experimentalDesign;
    }

    public function setExperimentalDesign(?ExperimentalDesign $experimentalDesign): void
    {
        $this->experimentalDesign = $experimentalDesign;
    }

    public function getControlOperations(): ?ControlOperations
    {
        return $this->controlOperations;
    }

    public function setControlOperations(?ControlOperations $controlOperations): void
    {
        $this->controlOperations = $controlOperations;
    }

    public function getOtherControlOperations(): ?string
    {
        return $this->otherControlOperations;
    }

    public function setOtherControlOperations(?string $otherControlOperations): void
    {
        $this->otherControlOperations = $otherControlOperations;
    }

    public function getResearchDesign(): ?ResearchDesign
    {
        return $this->researchDesign;
    }

    public function setResearchDesign(?ResearchDesign $researchDesign): static
    {
        $this->researchDesign = $researchDesign;

        return $this;
    }

    public function getResearchDesignDescription(): ?string
    {
        return $this->researchDesignDescription;
    }

    public function setResearchDesignDescription(?string $researchDesignDescription): static
    {
        $this->researchDesignDescription = $researchDesignDescription;

        return $this;
    }

    public function getSurveyInstrumentType(): ?SurveyInstrumentType
    {
        return $this->surveyInstrumentType;
    }

    public function setSurveyInstrumentType(?SurveyInstrumentType $surveyInstrumentType): static
    {
        $this->surveyInstrumentType = $surveyInstrumentType;

        return $this;
    }

    public function getTreatmentGroups(): ?array
    {
        return $this->treatmentGroups;
    }

    public function setTreatmentGroups(?array $treatmentGroups): static
    {
        $this->treatmentGroups = $treatmentGroups;

        return $this;
    }

    public function getResearchMethodDescription(): ?string
    {
        return $this->researchMethodDescription;
    }

    public function setResearchMethodDescription(?string $researchMethodDescription): static
    {
        $this->researchMethodDescription = $researchMethodDescription;

        return $this;
    }

    /**
     * @return Collection<int, MeasurementOccasion>
     */
    public function getMeasurementOccasions(): Collection
    {
        return $this->measurementOccasions;
    }

    public function addMeasurementOccasion(MeasurementOccasion $measurementOccasion): static
    {
        if (!$this->measurementOccasions->contains($measurementOccasion)) {
            $this->measurementOccasions->add($measurementOccasion);
            $measurementOccasion->setMethod($this);
        }

        return $this;
    }

    public function removeMeasurementOccasion(MeasurementOccasion $occasion): static
    {
        $this->measurementOccasions->removeElement($occasion);

        return $this;
    }

    public function getConstructs(): Collection
    {
        return $this->constructs;
    }

    public function addConstruct(MethodConstruct $construct): static
    {
        if (!$this->constructs->contains($construct)) {
            $this->constructs->add($construct);
            $construct->setMethod($this);
        }

        return $this;
    }

    public function removeConstruct(MethodConstruct $construct): static
    {
        $this->constructs->removeElement($construct);
        return $this;
    }

    /**
     * @return Collection<int, MeasurementInstrument>
     */
    public function getMeasurementInstruments(): Collection
    {
        return $this->measurementInstruments;
    }

    public function addMeasurementInstrument(MeasurementInstrument $measurementInstrument): static
    {
        if (!$this->measurementInstruments->contains($measurementInstrument)) {
            $this->measurementInstruments->add($measurementInstrument);
            $measurementInstrument->setMethod($this);
        }

        return $this;
    }

    public function removeMeasurementInstrument(MeasurementInstrument $measurementInstrument): static
    {
        $this->measurementInstruments->removeElement($measurementInstrument);
        return $this;
    }
}
