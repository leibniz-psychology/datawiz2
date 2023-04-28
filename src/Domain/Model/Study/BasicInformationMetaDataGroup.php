<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\ReviewDataDictionary;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\BasicInformationType;
use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use App\Review\ReviewValidator;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity
 * @ORM\Table(name="experiment_basic")
 */
class BasicInformationMetaDataGroup extends UuidEntity implements Questionable, Reviewable
{
    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     * @SerializedName("title")
     * @Groups({"study"})
     */
    private ?string $title = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("description")
     * @Groups({"study"})
     */
    private ?string $description = null;

    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     * @SerializedName("related_publications")
     * @Groups("study")
     */
    private ?array $related_publications = null;

    /**
     * One basic Information section has One Experiment.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="basicInformationMetaDataGroup")
     */
    private Experiment $experiment;

    /**
     * @SerializedName("creators")
     * @Groups("study")
     * @ORM\OneToMany(targetEntity="App\Domain\Model\Study\CreatorMetaDataGroup", mappedBy="basicInformation")
     */
    private Collection $creators;

    /**
     * @return string
     */
    public function getFormTypeForEntity(): string
    {
        return BasicInformationType::class;
    }

    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::TITLE,
                [$this->getTitle()],
                null != ReviewDataDictionary::TITLE['errorLevel'] && ReviewValidator::validateSingleValue($this->getTitle())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::DESCRIPTION,
                [$this->getDescription()],
                null != ReviewDataDictionary::DESCRIPTION['errorLevel'] && ReviewValidator::validateSingleValue($this->getDescription())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::RELATED_PUBS,
                $this->getRelatedPublications(),
                null != ReviewDataDictionary::RELATED_PUBS['errorLevel'] && ReviewValidator::validateArrayValues($this->getRelatedPublications())
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
        $this->related_publications = null == $related_publications ? null : array_values($related_publications);
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

    public function setCreators(?Collection $creators): void
    {
        $this->creators = $creators;
    }
}
