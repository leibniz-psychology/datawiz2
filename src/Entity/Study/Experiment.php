<?php

namespace App\Entity\Study;

use App\Entity\Administration\DataWizUser;
use App\Entity\Administration\UuidEntity;
use App\Entity\Constant\States;
use App\Entity\FileManagement\AdditionalMaterial;
use App\Entity\FileManagement\Dataset;
use App\Entity\Project\Project;
use App\Repository\Study\ExperimentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Entity(repositoryClass: ExperimentRepository::class)]
class Experiment extends UuidEntity
{
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
     * One Experiment has One Ethics section.
     */
    #[SerializedName('ethics')]
    #[Groups(['study'])]
    #[ORM\OneToOne(mappedBy: 'experiment', cascade: ['persist', 'remove'])]
    private ?EthicsMetaDataGroup $ethicsMetaDataGroup = null;

    /**
     * One Experiment has One Settings section.
     */
    #[SerializedName('settings')]
    #[Groups(['settings'])]
    #[ORM\OneToOne(mappedBy: 'experiment', cascade: ['persist', 'remove'])]
    private ?SettingsMetaDataGroup $settingsMetaDataGroup = null;

    #[ORM\OneToMany(targetEntity: Dataset::class, mappedBy: 'experiment', cascade: ['persist'])]
    #[SerializedName('datasets')]
    #[Groups(['dataset'])]
    private Collection $originalDatasets;

    #[ORM\OneToMany(targetEntity: AdditionalMaterial::class, mappedBy: 'experiment', cascade: ['persist'])]
    #[SerializedName('material')]
    #[Groups(['material'])]
    private Collection $additionalMaterials;

    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'experiments')]
    private Collection $projects;

    #[ORM\ManyToOne]
    private ?DataWizUser $owner = null;

    #[ORM\Column]
    #[Timestampable(on: 'create')]
    private ?\DateTime $dateCreated = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateSubmitted = null;

    #[ORM\Column]
    private int $state = States::STATE_STUDY_NONE;

    public function __construct()
    {
        $this->additionalMaterials = new ArrayCollection();
        $this->originalDatasets = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

    public function getOwner(): DataWizUser
    {
        return $this->owner;
    }

    public function setOwner(DataWizUser $owner): void
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

    public function getEthicsMetaDataGroup(): EthicsMetaDataGroup
    {
        return $this->ethicsMetaDataGroup;
    }

    public function setEthicsMetaDataGroup(EthicsMetaDataGroup $ethicsMetaDataGroup): void
    {
        $this->ethicsMetaDataGroup = $ethicsMetaDataGroup;
        $ethicsMetaDataGroup->setExperiment($this);
    }

    public function getAdditionalMaterials(): Collection
    {
        return $this->additionalMaterials;
    }

    public function addAdditionalMaterials(?AdditionalMaterial $additionalMaterials): void
    {
        if ($additionalMaterials != null) {
            $this->additionalMaterials->add($additionalMaterials);
        }
    }

    public function removeAdditionalMaterials(AdditionalMaterial $materials): void
    {
        $this->additionalMaterials->removeElement($materials);
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): void
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
        }
    }

    public function removeProject(Project $project): void
    {
        $this->projects->removeElement($project);
    }

    public function getOriginalDatasets(): Collection
    {
        return $this->originalDatasets;
    }

    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTime $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    public function getDateSubmitted(): ?\DateTime
    {
        return $this->dateSubmitted;
    }

    public function setDateSubmitted(?\DateTime $dateSubmitted): void
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
        if ($originalDatasets != null) {
            $this->originalDatasets->add($originalDatasets);
        }
    }

    public function removeOriginalDatasets(Dataset $originalDatasets): void
    {
        $this->originalDatasets->removeElement($originalDatasets);
    }
}
