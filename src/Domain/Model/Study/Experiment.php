<?php

namespace App\Domain\Model\Study;

use App\Domain\Access\Study\ExperimentRepository;
use App\Domain\Definition\States;
use App\Domain\Model\Administration\DataWizUser;
use App\Domain\Model\Administration\UuidEntity;
use App\Domain\Model\Filemanagement\AdditionalMaterial;
use App\Domain\Model\Filemanagement\Dataset;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass=ExperimentRepository::class)
 */
class Experiment extends UuidEntity
{

    public function __construct()
    {
        $this->additionalMaterials = new ArrayCollection();
        $this->originalDatasets = new ArrayCollection();
    }

    /**
     * One Experiment has One basic Information section.
     * @SerializedName("basic")
     * @Groups({"study"})
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\BasicInformationMetaDataGroup", mappedBy="experiment", cascade={"persist", "remove"})
     */
    private BasicInformationMetaDataGroup $basicInformationMetaDataGroup;

    /**
     * One Experiment has One Theory section.
     * @SerializedName("theory")
     * @Groups({"study"})
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\TheoryMetaDataGroup", mappedBy="experiment", cascade={"persist", "remove"})
     */
    private TheoryMetaDataGroup $theoryMetaDataGroup;

    /**
     * One Experiment has One Theory section.
     * @SerializedName("method")
     * @Groups({"study"})
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\MethodMetaDataGroup", mappedBy="experiment", cascade={"persist", "remove"})
     */
    private MethodMetaDataGroup $methodMetaDataGroup;

    /**
     * One Experiment has One Theory section.
     * @SerializedName("measure")
     * @Groups({"study"})
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\MeasureMetaDataGroup", mappedBy="experiment", cascade={"persist", "remove"})
     */
    private MeasureMetaDataGroup $measureMetaDataGroup;

    /**
     * One Experiment has One Sample section.
     * @SerializedName("sample")
     * @Groups({"study"})
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\SampleMetaDataGroup", mappedBy="experiment", cascade={"persist", "remove"})
     */
    private SampleMetaDataGroup $sampleMetaDataGroup;

    /**
     * One Experiment has One Settings section.
     * @SerializedName("settings")
     * @Groups({"settings"})
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\SettingsMetaDataGroup", mappedBy="experiment", cascade={"persist", "remove"})
     */
    private SettingsMetaDataGroup $settingsMetaDataGroup;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Model\Filemanagement\Dataset", mappedBy="experiment", cascade={"persist"})
     * @SerializedName("datasets")
     * @Groups({"dataset"})
     */
    private Collection $originalDatasets;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Model\Filemanagement\AdditionalMaterial", mappedBy="experiment", cascade={"persist"})
     * @SerializedName("material")
     * @Groups({"material"})
     */
    private Collection $additionalMaterials;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Administration\DataWizUser")
     *
     */
    private DataWizUser $owner;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $dateCreated;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $dateSubmitted = null;

    /**
     * @ORM\Column(type="integer")
     */
    private int $state = States::STATE_STUDY_NONE;

    /**
     * @return DataWizUser
     */
    public function getOwner(): DataWizUser
    {
        return $this->owner;
    }

    /**
     * @param DataWizUser $owner
     * @return void
     */
    private function setOwner(DataWizUser $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return SampleMetaDataGroup
     */
    public function getSampleMetaDataGroup(): SampleMetaDataGroup
    {
        return $this->sampleMetaDataGroup;
    }

    /**
     * @param SampleMetaDataGroup $sampleMetaDataGroup
     */
    public function setSampleMetaDataGroup(SampleMetaDataGroup $sampleMetaDataGroup): void
    {
        $this->sampleMetaDataGroup = $sampleMetaDataGroup;
        $sampleMetaDataGroup->setExperiment($this);
    }

    /**
     * @return SettingsMetaDataGroup
     */
    public function getSettingsMetaDataGroup(): SettingsMetaDataGroup
    {
        return $this->settingsMetaDataGroup;
    }

    /**
     * @param SettingsMetaDataGroup $settingsMetaDataGroup
     */
    public function setSettingsMetaDataGroup(SettingsMetaDataGroup $settingsMetaDataGroup): void
    {
        $this->settingsMetaDataGroup = $settingsMetaDataGroup;
        $settingsMetaDataGroup->setExperiment($this);
    }

    /**
     * @return BasicInformationMetaDataGroup
     */
    public function getBasicInformationMetaDataGroup(): BasicInformationMetaDataGroup
    {
        return $this->basicInformationMetaDataGroup;
    }

    /**
     * @param BasicInformationMetaDataGroup $basicInformationMetaDataGroup
     */
    public function setBasicInformationMetaDataGroup(BasicInformationMetaDataGroup $basicInformationMetaDataGroup): void
    {
        $this->basicInformationMetaDataGroup = $basicInformationMetaDataGroup;
        $basicInformationMetaDataGroup->setExperiment($this);
    }

    /**
     * @return TheoryMetaDataGroup
     */
    public function getTheoryMetaDataGroup(): TheoryMetaDataGroup
    {
        return $this->theoryMetaDataGroup;
    }

    /**
     * @param TheoryMetaDataGroup $theoryMetaDataGroup
     */
    public function setTheoryMetaDataGroup(TheoryMetaDataGroup $theoryMetaDataGroup): void
    {
        $this->theoryMetaDataGroup = $theoryMetaDataGroup;
        $theoryMetaDataGroup->setExperiment($this);
    }

    /**
     * @return MeasureMetaDataGroup
     */
    public function getMeasureMetaDataGroup(): MeasureMetaDataGroup
    {
        return $this->measureMetaDataGroup;
    }

    /**
     * @param MeasureMetaDataGroup $measureMetaDataGroup
     */
    public function setMeasureMetaDataGroup(MeasureMetaDataGroup $measureMetaDataGroup): void
    {
        $this->measureMetaDataGroup = $measureMetaDataGroup;
        $measureMetaDataGroup->setExperiment($this);
    }

    /**
     * @return MethodMetaDataGroup
     */
    public function getMethodMetaDataGroup(): MethodMetaDataGroup
    {
        return $this->methodMetaDataGroup;
    }

    /**
     * @param MethodMetaDataGroup $methodMetaDataGroup
     */
    public function setMethodMetaDataGroup(MethodMetaDataGroup $methodMetaDataGroup): void
    {
        $this->methodMetaDataGroup = $methodMetaDataGroup;
        $methodMetaDataGroup->setExperiment($this);
    }

    /**
     * @return Collection
     */
    public function getAdditionalMaterials(): Collection
    {
        return $this->additionalMaterials;
    }

    /**
     * @param AdditionalMaterial|null $additionalMaterials
     * @return void
     */
    public function addAdditionalMaterials(?AdditionalMaterial $additionalMaterials): void
    {
        if (null != $additionalMaterials) {
            $this->additionalMaterials->add($additionalMaterials);
        }
    }

    /**
     * @param AdditionalMaterial $materials
     * @return void
     */
    public function removeAdditionalMaterials(AdditionalMaterial $materials): void
    {
        $this->additionalMaterials->removeElement($materials);
    }

    /**
     * @return Collection
     */
    public function getOriginalDatasets(): Collection
    {
        return $this->originalDatasets;
    }

    /**
     * @return DateTime
     */
    public function getDateCreated(): DateTime
    {
        return $this->dateCreated;
    }

    /**
     * @param DateTime $dateCreated
     */
    public function setDateCreated(DateTime $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return DateTime|null
     */
    public function getDateSubmitted(): ?DateTime
    {
        return $this->dateSubmitted;
    }

    /**
     * @param DateTime|null $dateSubmitted
     */
    public function setDateSubmitted(?DateTime $dateSubmitted): void
    {
        $this->dateSubmitted = $dateSubmitted;
    }

    /**
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * @param int $state
     */
    public function setState(int $state): void
    {
        $this->state = $state;
    }


    /**
     * @param Dataset|null $originalDatasets
     * @return void
     */
    public function addOriginalDatasets(?Dataset $originalDatasets): void
    {
        if (null != $originalDatasets) {
            $this->originalDatasets->add($originalDatasets);
        }
    }

    /**
     * @param Dataset $originalDatasets
     * @return void
     */
    public function removeOriginalDatasets(Dataset $originalDatasets): void
    {
        $this->originalDatasets->removeElement($originalDatasets);
    }

    /**
     * @param DataWizUser $owner
     * @return Experiment
     */
    public static function createNewExperiment(DataWizUser $owner): Experiment
    {
        $newExperiment = new Experiment();
        $newExperiment->setSettingsMetaDataGroup(new SettingsMetaDataGroup());
        $newExperiment->setBasicInformationMetaDataGroup(new BasicInformationMetaDataGroup());
        $newExperiment->setTheoryMetaDataGroup(new TheoryMetaDataGroup());
        $newExperiment->setSampleMetaDataGroup(new SampleMetaDataGroup());
        $newExperiment->setMeasureMetaDataGroup(new MeasureMetaDataGroup());
        $newExperiment->setMethodMetaDataGroup(new MethodMetaDataGroup());
        $newExperiment->setOwner($owner);

        return $newExperiment;
    }


}
