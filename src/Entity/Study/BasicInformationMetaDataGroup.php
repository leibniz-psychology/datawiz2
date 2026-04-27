<?php

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Entity\Constant\ReviewDataDictionary;
use App\Enum\DataStatus;
use App\Enum\StudyRelation;
use App\Repository\BasicInformationRepository;
use App\Service\Review\Reviewable;
use App\Service\Review\ReviewDataCollectable;
use App\Service\Review\ReviewValidator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Table(name: 'experiment_basic')]
#[ORM\Entity(repositoryClass: BasicInformationRepository::class)]
class BasicInformationMetaDataGroup extends UuidEntity implements Reviewable
{
    /**
     * One basic Information section has One Experiment.
     */
    #[ORM\OneToOne(inversedBy: 'basicInformationMetaDataGroup', cascade: ['persist', 'remove'])]
    private ?Experiment $experiment = null;

    #[ORM\Column(type: 'text', length: 255, nullable: true)]
    #[SerializedName('title')]
    #[Groups(['study'])]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[SerializedName('title_translated')]
    #[Groups(['study'])]
    private ?string $titleTranslated = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[SerializedName('study_id')]
    #[Groups(['study'])]
    private ?string $studyId = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('description')]
    #[Groups(['study'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('description_translated')]
    #[Groups(['study'])]
    private ?string $descriptionTranslated = null;

    #[ORM\Column(nullable: true, enumType: DataStatus::class)]
    #[SerializedName('data_status')]
    #[Groups(['study'])]
    private ?DataStatus $dataStatus = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('data_status_other_description')]
    #[Groups(['study'])]
    private ?string $dataStatusOtherDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('reuse_potential_of_data_subset')]
    #[Groups(['study'])]
    private ?string $reusePotentialOfDataSubset = null;

    #[ORM\Column(nullable: true, enumType: StudyRelation::class)]
    #[SerializedName('study_relation')]
    #[Groups(['study'])]
    private ?StudyRelation $studyRelation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('study_relation_other_description')]
    #[Groups(['study'])]
    private ?string $studyRelationOtherDescription = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('used_softwares')]
    #[Groups(['study'])]
    private ?array $usedSoftwares = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('related_publications')]
    #[Groups('study')]
    private ?array $relatedPublications = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('conflicts_of_interest')]
    #[Groups(['study'])]
    private ?array $conflictsOfInterest = null;

    #[ORM\OneToMany(targetEntity: CreatorMetaDataGroup::class, mappedBy: 'basicInformation', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[SerializedName('creators')]
    #[Groups('study')]
    private Collection $creators;

    public function __construct()
    {
        $this->creators = new ArrayCollection();
    }

    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::TITLE,
                [$this->getTitle()],
                ReviewValidator::validateSingleValue($this->getTitle())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::DESCRIPTION,
                [$this->getDescription()],
                ReviewValidator::validateSingleValue($this->getDescription())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::RELATED_PUBS,
                $this->getRelatedPublications(),
                ReviewValidator::validateArrayValues($this->getRelatedPublications())
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getTitleTranslated(): ?string
    {
        return $this->titleTranslated;
    }

    public function setTitleTranslated(?string $titleTranslated): static
    {
        $this->titleTranslated = $titleTranslated;

        return $this;
    }

    public function getStudyId(): ?string
    {
        return $this->studyId;
    }

    public function setStudyId(?string $studyId): static
    {
        $this->studyId = $studyId;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDescriptionTranslated(): ?string
    {
        return $this->descriptionTranslated;
    }

    public function setDescriptionTranslated(?string $descriptionTranslated): static
    {
        $this->descriptionTranslated = $descriptionTranslated;

        return $this;
    }

    public function getDataStatus(): ?DataStatus
    {
        return $this->dataStatus;
    }

    public function setDataStatus(?DataStatus $dataStatus): static
    {
        $this->dataStatus = $dataStatus;

        return $this;
    }

    public function getDataStatusOtherDescription(): ?string
    {
        return $this->dataStatusOtherDescription;
    }

    public function setDataStatusOtherDescription(?string $dataStatusOtherDescription): static
    {
        $this->dataStatusOtherDescription = $dataStatusOtherDescription;

        return $this;
    }

    public function getReusePotentialOfDataSubset(): ?string
    {
        return $this->reusePotentialOfDataSubset;
    }

    public function setReusePotentialOfDataSubset(?string $reusePotentialOfDataSubset): static
    {
        $this->reusePotentialOfDataSubset = $reusePotentialOfDataSubset;

        return $this;
    }

    public function getStudyRelation(): ?StudyRelation
    {
        return $this->studyRelation;
    }

    public function setStudyRelation(?StudyRelation $studyRelation): static
    {
        $this->studyRelation = $studyRelation;

        return $this;
    }

    public function getStudyRelationOtherDescription(): ?string
    {
        return $this->studyRelationOtherDescription;
    }

    public function setStudyRelationOtherDescription(?string $studyRelationOtherDescription): static
    {
        $this->studyRelationOtherDescription = $studyRelationOtherDescription;

        return $this;
    }

    public function getUsedSoftwares(): ?array
    {
        return $this->usedSoftwares;
    }

    public function setUsedSoftwares(?array $usedSoftwares): static
    {
        $this->usedSoftwares = $usedSoftwares;

        return $this;
    }

    public function getRelatedPublications(): ?array
    {
        return $this->relatedPublications;
    }

    public function setRelatedPublications(?array $relatedPublications): void
    {
        $this->relatedPublications = $relatedPublications == null ? null : array_values($relatedPublications);
    }

    public function getConflictsOfInterest(): ?array
    {
        return $this->conflictsOfInterest;
    }

    public function setConflictsOfInterest(?array $conflictsOfInterest): static
    {
        $this->conflictsOfInterest = $conflictsOfInterest;

        return $this;
    }

    public function getCreators(): ?Collection
    {
        return $this->creators;
    }

    public function addCreator(CreatorMetaDataGroup $creator): static
    {
        if (!$this->creators->contains($creator)) {
            $this->creators->add($creator);
            $creator->setBasicInformation($this);
        }

        return $this;
    }

    public function removeCreator(CreatorMetaDataGroup $creator): static
    {
        $this->creators->removeElement($creator);

        return $this;
    }
}
