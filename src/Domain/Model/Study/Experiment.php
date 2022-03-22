<?php

namespace App\Domain\Model\Study;

use App\Domain\Access\Study\ExperimentRepository;
use App\Domain\Model\Administration\UuidEntity;
use App\Domain\Model\Filemanagement\AdditionalMaterial;
use App\Domain\Model\Filemanagement\Dataset;
use App\Security\Authorization\Ownable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass=ExperimentRepository::class)
 */
class Experiment extends UuidEntity implements Ownable
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
    private $basicInformationMetaDataGroup;

    /**
     * One Experiment has One Theory section.
     * @SerializedName("theory")
     * @Groups({"study"})
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\TheoryMetaDataGroup", mappedBy="experiment", cascade={"persist", "remove"})
     */
    private $theoryMetaDataGroup;

    /**
     * One Experiment has One Theory section.
     * @SerializedName("method")
     * @Groups({"study"})
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\MethodMetaDataGroup", mappedBy="experiment", cascade={"persist", "remove"})
     */
    private $methodMetaDataGroup;

    /**
     * One Experiment has One Theory section.
     * @SerializedName("measure")
     * @Groups({"study"})
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\MeasureMetaDataGroup", mappedBy="experiment", cascade={"persist", "remove"})
     */
    private $measureMetaDataGroup;

    /**
     * One Experiment has One Sample section.
     * @SerializedName("sample")
     * @Groups({"study"})
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\SampleMetaDataGroup", mappedBy="experiment", cascade={"persist", "remove"})
     */
    private $sampleMetaDataGroup;

    /**
     * One Experiment has One Settings section.
     * @SerializedName("settings")
     * @Groups({"settings"})
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\SettingsMetaDataGroup", mappedBy="experiment", cascade={"persist", "remove"})
     */
    private $settingsMetaDataGroup;

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
    private $owner;

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    private function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getSampleMetaDataGroup()
    {
        return $this->sampleMetaDataGroup;
    }

    /**
     * @param mixed $sampleMetaDataGroup
     */
    public function setSampleMetaDataGroup(SampleMetaDataGroup $sampleMetaDataGroup): void
    {
        $this->sampleMetaDataGroup = $sampleMetaDataGroup;
        $sampleMetaDataGroup->setExperiment($this);
    }

    /**
     * @return mixed
     */
    public function getSettingsMetaDataGroup()
    {
        return $this->settingsMetaDataGroup;
    }

    /**
     * @param mixed $settingsMetaDataGroup
     */
    public function setSettingsMetaDataGroup(SettingsMetaDataGroup $settingsMetaDataGroup): void
    {
        $this->settingsMetaDataGroup = $settingsMetaDataGroup;
        $settingsMetaDataGroup->setExperiment($this);
    }

    /**
     * @return mixed
     */
    public function getBasicInformationMetaDataGroup()
    {
        return $this->basicInformationMetaDataGroup;
    }

    /**
     * @param mixed $basicInformationMetaDataGroup
     */
    public function setBasicInformationMetaDataGroup(BasicInformationMetaDataGroup $basicInformationMetaDataGroup): void
    {
        $this->basicInformationMetaDataGroup = $basicInformationMetaDataGroup;
        $basicInformationMetaDataGroup->setExperiment($this);
    }

    /**
     * @return mixed
     */
    public function getTheoryMetaDataGroup()
    {
        return $this->theoryMetaDataGroup;
    }

    /**
     * @param mixed $theoryMetaDataGroup
     */
    public function setTheoryMetaDataGroup(TheoryMetaDataGroup $theoryMetaDataGroup): void
    {
        $this->theoryMetaDataGroup = $theoryMetaDataGroup;
        $theoryMetaDataGroup->setExperiment($this);
    }

    /**
     * @return mixed
     */
    public function getMeasureMetaDataGroup()
    {
        return $this->measureMetaDataGroup;
    }

    /**
     * @param mixed $measureMetaDataGroup
     */
    public function setMeasureMetaDataGroup(MeasureMetaDataGroup $measureMetaDataGroup): void
    {
        $this->measureMetaDataGroup = $measureMetaDataGroup;
        $measureMetaDataGroup->setExperiment($this);
    }

    /**
     * @return mixed
     */
    public function getMethodMetaDataGroup()
    {
        return $this->methodMetaDataGroup;
    }

    /**
     * @param mixed $methodMetaDataGroup
     */
    public function setMethodMetaDataGroup(MethodMetaDataGroup $methodMetaDataGroup): void
    {
        $this->methodMetaDataGroup = $methodMetaDataGroup;
        $methodMetaDataGroup->setExperiment($this);
    }

    public function getAdditionalMaterials(): Collection
    {
        return $this->additionalMaterials;
    }

    public function addAdditionalMaterials(?AdditionalMaterial $additionalMaterials): void
    {
        if (null != $additionalMaterials) {
            $this->additionalMaterials->add($additionalMaterials);
        }
    }

    public function removeAdditionalMaterials(AdditionalMaterial $materials): void
    {
        $this->additionalMaterials->removeElement($materials);
    }

    public function getOriginalDatasets(): Collection
    {
        return $this->originalDatasets;
    }

    public function addOriginalDatasets(?Dataset $originalDatasets): void
    {
        if (null != $originalDatasets) {
            $this->originalDatasets->add($originalDatasets);
        }
    }

    public function removeOriginalDatasets(Dataset $originalDatasets): void
    {
        $this->originalDatasets->removeElement($originalDatasets);
    }

    public static function createNewExperiment(UserInterface $owner): Experiment
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
