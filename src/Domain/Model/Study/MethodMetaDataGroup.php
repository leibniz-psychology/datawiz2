<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\ReviewDataDictionary;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\MethodType;
use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use App\Review\ReviewValidator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity()
 * @ORM\Table(name="experiment_method")
 */
class MethodMetaDataGroup extends UuidEntity implements Questionable, Reviewable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("research_design")
     * @Groups({"study"})
     */
    private ?string $research_design = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("experimental_details")
     * @Groups({"experimental"})
     */
    private ?string $experimental_details = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("non_experimental_details")
     * @Groups({"non_experimental"})
     */
    private ?string $non_experimental_details = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("observational_type")
     * @Groups({"non_experimental"})
     */
    private ?string $observational_type = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("setting")
     * @Groups({"study"})
     */
    private ?string $setting = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("setting_location")
     * @Groups({"study"})
     */
    private ?string $setting_location = null;


    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("manipulations")
     * @Groups({"experimental"})
     */
    private ?string $manipulations = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("experimental_design")
     * @Groups({"experimental"})
     */
    private ?string $experimental_design = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("control_operations")
     * @Groups({"experimental"})
     */
    private ?string $control_operations = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("other_control_operations")
     * @Groups({"experimental"})
     */
    private ?string $other_control_operations = null;

    /**
     * One basic Information section has One Experiment.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="methodMetaDataGroup")
     */
    protected Experiment $experiment;

    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::DESIGN,
                [$this->getResearchDesign()],
                null != ReviewDataDictionary::DESIGN['errorLevel'] && ReviewValidator::validateSingleValue($this->getResearchDesign())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::EXPERIMENTAL,
                [$this->getExperimentalDetails()],
                null != ReviewDataDictionary::EXPERIMENTAL['errorLevel'] && ReviewValidator::validateSingleValue($this->getExperimentalDetails()),
                "Experimental" === $this->getResearchDesign()
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::NON_EXPERIMENTAL,
                [$this->getNonExperimentalDetails()],
                null != ReviewDataDictionary::NON_EXPERIMENTAL['errorLevel'] && ReviewValidator::validateSingleValue($this->getNonExperimentalDetails()),
                "Non-experimental" === $this->getResearchDesign()
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::OBSERVABLE_TYPE,
                [$this->getObservationalType()],
                null != ReviewDataDictionary::OBSERVABLE_TYPE['errorLevel'] && ReviewValidator::validateSingleValue($this->getObservationalType()),
                "Non-experimental" === $this->getResearchDesign() && "Observational study" === $this->getNonExperimentalDetails()
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::SETTING,
                [$this->getSetting()],
                null != ReviewDataDictionary::SETTING['errorLevel'] && ReviewValidator::validateSingleValue($this->getSetting())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::SETTING_LOCATION,
                [$this->getSettingLocation()],
                null != ReviewDataDictionary::SETTING_LOCATION['errorLevel'] && ReviewValidator::validateSingleValue($this->getSettingLocation()),
                'Real-life setting' === $this->getSetting() || 'Natural setting' === $this->getSetting()
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::MANIPULATIONS,
                [$this->getManipulations()],
                null != ReviewDataDictionary::MANIPULATIONS['errorLevel'] && ReviewValidator::validateSingleValue($this->getManipulations()),
                "Experimental" === $this->getResearchDesign()
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::EXPERIMENTAL_DESIGN,
                [$this->getExperimentalDesign()],
                null != ReviewDataDictionary::EXPERIMENTAL_DESIGN['errorLevel'] && ReviewValidator::validateSingleValue($this->getExperimentalDesign()),
                "Experimental" === $this->getResearchDesign()
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::CONTROL_OPS,
                ["Other" !== $this->getControlOperations() ? $this->getControlOperations() : $this->getOtherControlOperations()],
                null != ReviewDataDictionary::CONTROL_OPS['errorLevel'] &&
                ("Other" !== $this->getControlOperations() && ReviewValidator::validateSingleValue($this->getControlOperations())) ||
                ("Other" === $this->getControlOperations() && ReviewValidator::validateSingleValue($this->getOtherControlOperations())),
                "Experimental" === $this->getResearchDesign()
            ),
        ];
    }

    public function getFormTypeForEntity(): string
    {
        return MethodType::class;
    }

    public function getSetting(): ?string
    {
        return $this->setting;
    }

    public function setSetting(?string $setting): void
    {
        $this->setting = $setting;
    }

    public function getSettingLocation(): ?string
    {
        return $this->setting_location;
    }

    public function setSettingLocation(?string $setting_location): void
    {
        $this->setting_location = $setting_location;
    }

    public function getResearchDesign(): ?string
    {
        return $this->research_design;
    }

    public function setResearchDesign(?string $research_design): void
    {
        $this->research_design = $research_design;
    }

    public function getExperimentalDetails(): ?string
    {
        return $this->experimental_details;
    }

    public function setExperimentalDetails(?string $experimental_details): void
    {
        $this->experimental_details = $experimental_details;
    }

    public function getNonExperimentalDetails(): ?string
    {
        return $this->non_experimental_details;
    }

    public function setNonExperimentalDetails(?string $non_experimental_details): void
    {
        $this->non_experimental_details = $non_experimental_details;
    }

    public function getObservationalType(): ?string
    {
        return $this->observational_type;
    }

    public function setObservationalType(?string $observational_type): void
    {
        $this->observational_type = $observational_type;
    }

    public function getManipulations(): ?string
    {
        return $this->manipulations;
    }

    public function setManipulations(?string $manipulations): void
    {
        $this->manipulations = $manipulations;
    }

    public function getExperimentalDesign(): ?string
    {
        return $this->experimental_design;
    }

    public function setExperimentalDesign(?string $experimental_design): void
    {
        $this->experimental_design = $experimental_design;
    }

    public function getControlOperations(): ?string
    {
        return $this->control_operations;
    }

    public function setControlOperations(?string $control_operations): void
    {
        $this->control_operations = $control_operations;
    }

    public function getOtherControlOperations(): ?string
    {
        return $this->other_control_operations;
    }

    public function setOtherControlOperations(?string $other_control_operations): void
    {
        $this->other_control_operations = $other_control_operations;
    }

    public function getExperiment(): Experiment
    {
        return $this->experiment;
    }

    public function setExperiment(Experiment $experiment): void
    {
        $this->experiment = $experiment;
    }
}
