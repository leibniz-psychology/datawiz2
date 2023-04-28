<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\ReviewDataDictionary;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\MeasureType;
use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use App\Review\ReviewValidator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Table(name: 'experiment_measure')]
#[ORM\Entity]
class MeasureMetaDataGroup extends UuidEntity implements Questionable, Reviewable
{

    #[ORM\Column(length: 1500, nullable: true)]
    #[SerializedName('measures')]
    #[Groups(['study'])]
    private ?array $measures = null;

    #[ORM\Column(length: 1500, nullable: true)]
    #[SerializedName('apparatus')]
    #[Groups(['study'])]
    private ?array $apparatus = null;

    /**
     * One basic Information section has One Experiment.
     */
    #[ORM\OneToOne(inversedBy: 'measureMetaDataGroup')]
    protected ?Experiment $experiment = null;

    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::MEASURES,
                $this->getMeasures(),
                null != ReviewDataDictionary::MEASURES['errorLevel'] && ReviewValidator::validateArrayValues($this->getMeasures())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::APPARATUS,
                $this->getApparatus(),
                null != ReviewDataDictionary::APPARATUS['errorLevel'] && ReviewValidator::validateArrayValues($this->getApparatus())
            ),
        ];
    }

    public function getFormTypeForEntity(): string
    {
        return MeasureType::class;
    }

    public function getMeasures(): ?array
    {
        return $this->measures;
    }

    public function setMeasures(?array $measures): void
    {
        $this->measures = null == $measures ? null : array_values($measures);
    }

    public function getApparatus(): ?array
    {
        return $this->apparatus;
    }

    public function setApparatus(?array $apparatus): void
    {
        $this->apparatus = null == $apparatus ? null : array_values($apparatus);
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
