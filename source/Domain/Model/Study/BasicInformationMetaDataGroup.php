<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\ReviewDataDictionary;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\BasicInformationType;
use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use App\Review\ReviewValidator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="experiment_basic")
 */
class BasicInformationMetaDataGroup extends UuidEntity implements Questionable, Reviewable
{
    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private ?string $title = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $description = null;

    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     */
    private ?array $related_publications = null;

    /**
     * One basic Information section has One Experiment.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="basicInformationMetaDataGroup")
     */
    private Experiment $experiment;

    /**
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

    /**
     * @return array
     */
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

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return array|null
     */
    public function getRelatedPublications(): ?array
    {
        if ($this->related_publications === null) {
            $this->related_publications = array('');
        }

        return $this->related_publications;
    }

    /**
     * @param array|null $related_publications
     */
    public function setRelatedPublications(?array $related_publications): void
    {
        $this->related_publications = null == $related_publications ? null : array_values($related_publications);
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

    /**
     * @return ArrayCollection|Collection
     */
    public function getCreators()
    {
        return $this->creators;
    }

    /**
     * @param ArrayCollection|Collection $creators
     */
    public function setCreators($creators): void
    {
        $this->creators = $creators;
    }
}
