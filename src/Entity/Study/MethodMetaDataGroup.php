<?php

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Entity\Constant\ReviewDataDictionary;
use App\Enum\ControlOperations;
use App\Enum\ExperimentalDesign;
use App\Enum\ExperimentalDetails;
use App\Enum\NonExperimentalDetails;
use App\Enum\ObservationalType;
use App\Enum\ResearchMethod;
use App\Enum\StudySetting;
use App\Repository\MethodRepository;
use App\Service\Review\Reviewable;
use App\Service\Review\ReviewDataCollectable;
use App\Service\Review\ReviewValidator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Table(name: 'experiment_method')]
#[ORM\Entity(repositoryClass: MethodRepository::class)]
class MethodMetaDataGroup extends UuidEntity implements Reviewable
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

    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::DESIGN,
                [$this->getResearchMethod()],
                ReviewValidator::validateSingleValue($this->getResearchMethod()->label())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::EXPERIMENTAL,
                [$this->getExperimentalDetails()],
                ReviewValidator::validateSingleValue($this->getExperimentalDetails()->label()),
                $this->getResearchMethod() === ResearchMethod::EXPERIMENTAL
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::NON_EXPERIMENTAL,
                [$this->getNonExperimentalDetails()],
                ReviewValidator::validateSingleValue($this->getNonExperimentalDetails()->label()),
                $this->getResearchMethod() === ResearchMethod::NON_EXPERIMENTAL
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::OBSERVABLE_TYPE,
                [$this->getObservationalType()],
                ReviewValidator::validateSingleValue($this->getObservationalType()?->label()),
                $this->getResearchMethod() === ResearchMethod::NON_EXPERIMENTAL && $this->getNonExperimentalDetails() === NonExperimentalDetails::OBSERVATIONAL_STUDY
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::SETTING,
                [$this->getSetting()],
                ReviewValidator::validateSingleValue($this->getSetting()->label())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::SETTING_LOCATION,
                [$this->getSettingLocation()],
                ReviewValidator::validateSingleValue($this->getSettingLocation()),
                $this->getSetting() === StudySetting::REAL_LIFE || $this->getSetting() === StudySetting::NATURAL
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::MANIPULATIONS,
                [$this->getManipulations()],
                ReviewValidator::validateSingleValue($this->getManipulations()),
                $this->getResearchMethod() === ResearchMethod::EXPERIMENTAL
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::EXPERIMENTAL_DESIGN,
                [$this->getExperimentalDesign()],
                ReviewValidator::validateSingleValue($this->getExperimentalDesign()),
                $this->getResearchMethod() === ResearchMethod::EXPERIMENTAL
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::CONTROL_OPS,
                [$this->getControlOperations() !== ControlOperations::OTHER ? $this->getControlOperations() : $this->getOtherControlOperations()],
                ($this->getControlOperations() !== ControlOperations::OTHER && ReviewValidator::validateSingleValue($this->getControlOperations()))
                || ($this->getControlOperations() === ControlOperations::OTHER && ReviewValidator::validateSingleValue($this->getOtherControlOperations())),
                $this->getResearchMethod() === ResearchMethod::EXPERIMENTAL
            ),
        ];
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
}
