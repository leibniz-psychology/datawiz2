<?php

namespace App\Domain\Model\Study;

use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\MethodType;
use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="experiment_method")
 */
class MethodMetaDataGroup extends UuidEntity implements Questionable, Reviewable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $setting = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $setting_location = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $research_design = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $experimental_details = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $non_experimental_details = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $observational_type = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $manipulations = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $experimental_design = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $control_operations = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $other_control_operations = null;

    /**
     * One basic Information section has One Experiment.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="methodMetaDataGroup")
     */
    protected Experiment $experiment;

    /**
     * @return array
     */
    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom('Research Design', [$this->getDesignDetails()]),
            ReviewDataCollectable::createFrom('Setting', [$this->getSetting()]),
            ReviewDataCollectable::createFrom('Manipulations', [$this->getManipulations()]), // TODO: conditional entry
            ReviewDataCollectable::createFrom('Design', [$this->getExperimentalDesign()]), // TODO: conditional entry
            ReviewDataCollectable::createFrom('Control operations', [$this->getControlOperations()]),// TODO: conditional entry
        ];
    }

    /**
     * @return string
     */
    public function getFormTypeForEntity(): string
    {
        return MethodType::class;
    }

    /**
     * @return string|null
     */
    public function getDesignDetails(): ?string
    {
        if ($this->research_design === "Experimental") {
            return $this->experimental_details;
        } elseif ($this->research_design === "Non-Experimental") {
            return $this->non_experimental_details;
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getSetting(): ?string
    {
        return $this->setting;
    }

    /**
     * @param string|null $setting
     */
    public function setSetting(?string $setting): void
    {
        $this->setting = $setting;
    }

    /**
     * @return string|null
     */
    public function getSettingLocation(): ?string
    {
        return $this->setting_location;
    }

    /**
     * @param string|null $setting_location
     */
    public function setSettingLocation(?string $setting_location): void
    {
        $this->setting_location = $setting_location;
    }

    /**
     * @return string|null
     */
    public function getResearchDesign(): ?string
    {
        return $this->research_design;
    }

    /**
     * @param string|null $research_design
     */
    public function setResearchDesign(?string $research_design): void
    {
        $this->research_design = $research_design;
    }

    /**
     * @return string|null
     */
    public function getExperimentalDetails(): ?string
    {
        return $this->experimental_details;
    }

    /**
     * @param string|null $experimental_details
     */
    public function setExperimentalDetails(?string $experimental_details): void
    {
        $this->experimental_details = $experimental_details;
    }

    /**
     * @return string|null
     */
    public function getNonExperimentalDetails(): ?string
    {
        return $this->non_experimental_details;
    }

    /**
     * @param string|null $non_experimental_details
     */
    public function setNonExperimentalDetails(?string $non_experimental_details): void
    {
        $this->non_experimental_details = $non_experimental_details;
    }

    /**
     * @return string|null
     */
    public function getObservationalType(): ?string
    {
        return $this->observational_type;
    }

    /**
     * @param string|null $observational_type
     */
    public function setObservationalType(?string $observational_type): void
    {
        $this->observational_type = $observational_type;
    }

    /**
     * @return string|null
     */
    public function getManipulations(): ?string
    {
        return $this->manipulations;
    }

    /**
     * @param string|null $manipulations
     */
    public function setManipulations(?string $manipulations): void
    {
        $this->manipulations = $manipulations;
    }

    /**
     * @return string|null
     */
    public function getExperimentalDesign(): ?string
    {
        return $this->experimental_design;
    }

    /**
     * @param string|null $experimental_design
     */
    public function setExperimentalDesign(?string $experimental_design): void
    {
        $this->experimental_design = $experimental_design;
    }

    /**
     * @return string|null
     */
    public function getControlOperations(): ?string
    {
        if ($this->control_operations === "Others") {
            return $this->other_control_operations;
        }

        return $this->control_operations;
    }

    /**
     * @param string|null $control_operations
     */
    public function setControlOperations(?string $control_operations): void
    {
        $this->control_operations = $control_operations;
    }

    /**
     * @return string|null
     */
    public function getOtherControlOperations(): ?string
    {
        return $this->other_control_operations;
    }

    /**
     * @param string|null $other_control_operations
     */
    public function setOtherControlOperations(?string $other_control_operations): void
    {
        $this->other_control_operations = $other_control_operations;
    }

    /**
     * @return Experiment
     */
    public function getExperiment(): Experiment
    {
        return $this->experiment;
    }

    /**
     * @param Experiment $experiment
     */
    public function setExperiment(Experiment $experiment): void
    {
        $this->experiment = $experiment;
    }
}
