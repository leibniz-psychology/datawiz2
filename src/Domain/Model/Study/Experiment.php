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

#[ORM\Entity(repositoryClass: ExperimentRepository::class)]
class Experiment extends UuidEntity
{

    public function __construct()
    {
        $this->additionalMaterials = new ArrayCollection();
        $this->originalDatasets = new ArrayCollection();
    }

    /**
     * One Experiment has One basic Information section.
     */
    #[SerializedName('basic')]
    #[Groups(['study'])]
    #[ORM\OneToOne(mappedBy: 'experiment', cascade: ['persist', 'remove'])]
    private ?BasicInformationMetaDataGroup $basicInformationMetaDataGroup = null;

    /**
     * One Experiment has One Theory section.
     */
    #[SerializedName('theory')]
    #[Groups(['study'])]
    #[ORM\OneToOne(mappedBy: 'experiment', cascade: ['persist', 'remove'])]
    private ?TheoryMetaDataGroup $theoryMetaDataGroup = null;

    /**
     * One Experiment has One Theory section.
     */
    #[SerializedName('method')]
    #[Groups(['study'])]
    #[ORM\OneToOne(mappedBy: 'experiment', cascade: ['persist', 'remove'])]
    private ?MethodMetaDataGroup $methodMetaDataGroup = null;

    /**
     * One Experiment has One Theory section.
     */
    #[SerializedName('measure')]
    #[Groups(['study'])]
    #[ORM\OneToOne(mappedBy: 'experiment', cascade: ['persist', 'remove'])]
    private ?MeasureMetaDataGroup $measureMetaDataGroup = null;

    /**
     * One Experiment has One Sample section.
     */
    #[SerializedName('sample')]
    #[Groups(['study'])]
    #[ORM\OneToOne(mappedBy: 'experiment', cascade: ['persist', 'remove'])]
    private ?SampleMetaDataGroup $sampleMetaDataGroup = null;

    /**
     * One Experiment has One Settings section.
     */
    #[SerializedName('settings')]
    #[Groups(['settings'])]
    #[ORM\OneToOne(mappedBy: 'experiment', cascade: ['persist', 'remove'])]
    private ?SettingsMetaDataGroup $settingsMetaDataGroup = null;

    #[ORM\OneToMany(mappedBy: 'experiment', targetEntity: 'App\Domain\Model\Filemanagement\Dataset', cascade: ['persist'])]
    #[SerializedName('datasets')]
    #[Groups(['dataset'])]
    private Collection $originalDatasets;

    #[ORM\OneToMany(mappedBy: 'experiment', targetEntity: 'App\Domain\Model\Filemanagement\AdditionalMaterial', cascade: ['persist'])]
    #[SerializedName('material')]
    #[Groups(['material'])]
    private Collection $additionalMaterials;

    #[ORM\ManyToOne()]
    private ?DataWizUser $owner = null;

    #[ORM\Column()]
    private ?DateTime $dateCreated = null;

    #[ORM\Column(nullable: true)]
    private ?DateTime $dateSubmitted = null;

    #[ORM\Column()]
    private int $state = States::STATE_STUDY_NONE;

    public function getOwner(): DataWizUser
    {
        return $this->owner;
    }

    private function setOwner(DataWizUser $owner): void
    {
        $this->owner = $owner;
    }

    public function getSampleMetaDataGroup(): SampleMetaDataGroup
    {
        return $this->sampleMetaDataGroup;
    }

    public function setSampleMetaDataGroup(SampleMetaDataGroup $sampleMetaDataGroup): void
    {
        $this->sampleMetaDataGroup = $sampleMetaDataGroup;
        $sampleMetaDataGroup->setExperiment($this);
    }

    public function getSettingsMetaDataGroup(): SettingsMetaDataGroup
    {
        return $this->settingsMetaDataGroup;
    }

    public function setSettingsMetaDataGroup(SettingsMetaDataGroup $settingsMetaDataGroup): void
    {
        $this->settingsMetaDataGroup = $settingsMetaDataGroup;
        $settingsMetaDataGroup->setExperiment($this);
    }

    public function getBasicInformationMetaDataGroup(): BasicInformationMetaDataGroup
    {
        return $this->basicInformationMetaDataGroup;
    }

    public function setBasicInformationMetaDataGroup(BasicInformationMetaDataGroup $basicInformationMetaDataGroup): void
    {
        $this->basicInformationMetaDataGroup = $basicInformationMetaDataGroup;
        $basicInformationMetaDataGroup->setExperiment($this);
    }

    public function getTheoryMetaDataGroup(): TheoryMetaDataGroup
    {
        return $this->theoryMetaDataGroup;
    }

    public function setTheoryMetaDataGroup(TheoryMetaDataGroup $theoryMetaDataGroup): void
    {
        $this->theoryMetaDataGroup = $theoryMetaDataGroup;
        $theoryMetaDataGroup->setExperiment($this);
    }

    public function getMeasureMetaDataGroup(): MeasureMetaDataGroup
    {
        return $this->measureMetaDataGroup;
    }

    public function setMeasureMetaDataGroup(MeasureMetaDataGroup $measureMetaDataGroup): void
    {
        $this->measureMetaDataGroup = $measureMetaDataGroup;
        $measureMetaDataGroup->setExperiment($this);
    }

    public function getMethodMetaDataGroup(): MethodMetaDataGroup
    {
        return $this->methodMetaDataGroup;
    }

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

    public function getDateCreated(): DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated(DateTime $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    public function getDateSubmitted(): ?DateTime
    {
        return $this->dateSubmitted;
    }

    public function setDateSubmitted(?DateTime $dateSubmitted): void
    {
        $this->dateSubmitted = $dateSubmitted;
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function setState(int $state): void
    {
        $this->state = $state;
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
