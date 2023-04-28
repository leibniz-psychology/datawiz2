<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\ReviewDataDictionary;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\TheoryType;
use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use App\Review\ReviewValidator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Table(name: 'experiment_theory')]
#[ORM\Entity]
class TheoryMetaDataGroup extends UuidEntity implements Questionable, Reviewable
{
    #[ORM\Column(type: 'text', length: 1500, nullable: true)]
    #[SerializedName('objective')]
    #[Groups(['study'])]
    private ?string $objective = null;

    #[ORM\Column(type: 'text', length: 1500, nullable: true)]
    #[SerializedName('hypothesis')]
    #[Groups(['study'])]
    private ?string $hypothesis = null;


    /**
     * One Theory section has One Experiment.
     */
    #[ORM\OneToOne(inversedBy: 'theoryMetaDataGroup')]
    protected ?Experiment $experiment = null;


    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::OBJECTIVES,
                [$this->getObjective()],
                null != ReviewDataDictionary::OBJECTIVES['errorLevel'] && ReviewValidator::validateSingleValue($this->getObjective())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::HYPOTHESIS,
                [$this->getHypothesis()],
                null != ReviewDataDictionary::HYPOTHESIS['errorLevel'] && ReviewValidator::validateSingleValue($this->getHypothesis())
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
