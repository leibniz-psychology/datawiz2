<?php

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Entity\Constant\ReviewDataDictionary;
use App\Repository\BasicInformationRepository;
use App\Service\Review\Reviewable;
use App\Service\Review\ReviewDataCollectable;
use App\Service\Review\ReviewValidator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Table(name: 'experiment_basic')]
#[ORM\Entity(repositoryClass: BasicInformationRepository::class)]
class BasicInformationMetaDataGroup extends UuidEntity implements Reviewable
{
    #[ORM\Column(type: 'text', length: 255, nullable: true)]
    #[SerializedName('title')]
    #[Groups(['study'])]
    private ?string $title = null;

    #[ORM\Column(type: 'text', length: 1500, nullable: true)]
    #[SerializedName('description')]
    #[Groups(['study'])]
    private ?string $description = null;

    #[ORM\Column(type: 'json', length: 1500, nullable: true)]
    #[SerializedName('related_publications')]
    #[Groups('study')]
    private ?array $related_publications = null;

    /**
     * One basic Information section has One Experiment.
     */
    #[ORM\OneToOne(inversedBy: 'basicInformationMetaDataGroup', cascade: ['persist', 'remove'])]
    private ?Experiment $experiment = null;

    #[SerializedName('creators')]
    #[Groups('study')]
    #[ORM\OneToMany(targetEntity: CreatorMetaDataGroup::class, mappedBy: 'basicInformation', cascade: ['persist', 'remove'], orphanRemoval: true)]
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getRelatedPublications(): ?array
    {
        return $this->related_publications;
    }

    public function setRelatedPublications(?array $related_publications): void
    {
        $this->related_publications = $related_publications == null ? null : array_values($related_publications);
    }

    public function getExperiment(): Experiment
    {
        return $this->experiment;
    }

    public function setExperiment(Experiment $experiment): void
    {
        $this->experiment = $experiment;
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
