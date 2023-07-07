<?php

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Entity\Constant\ReviewDataDictionary;
use App\Form\TheoryType;
use App\Service\Questionnaire\Questionable;
use App\Service\Review\Reviewable;
use App\Service\Review\ReviewDataCollectable;
use App\Service\Review\ReviewValidator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Table(name: 'experiment_theory')]
#[ORM\Entity]
class TheoryMetaDataGroup extends UuidEntity implements Questionable, Reviewable
{
    /**
     * One Theory section has One Experiment.
     */
    #[ORM\OneToOne(inversedBy: 'theoryMetaDataGroup')]
    protected ?Experiment $experiment = null;

    #[ORM\Column(type: 'text', length: 1500, nullable: true)]
    #[SerializedName('objective')]
    #[Groups(['study'])]
    private ?string $objective = null;

    #[ORM\Column(type: 'text', length: 1500, nullable: true)]
    #[SerializedName('hypothesis')]
    #[Groups(['study'])]
    private ?string $hypothesis = null;

    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::OBJECTIVES,
                [$this->getObjective()],
                ReviewValidator::validateSingleValue($this->getObjective())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::HYPOTHESIS,
                [$this->getHypothesis()],
                ReviewValidator::validateSingleValue($this->getHypothesis())
            ),
        ];
    }

    public function getFormTypeForEntity(): string
    {
        return TheoryType::class;
    }

    public function getObjective(): ?string
    {
        return $this->objective;
    }

    public function setObjective(?string $objective): void
    {
        $this->objective = $objective;
    }

    public function getHypothesis(): ?string
    {
        return $this->hypothesis;
    }

    public function setHypothesis(?string $hypothesis): void
    {
        $this->hypothesis = $hypothesis;
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
