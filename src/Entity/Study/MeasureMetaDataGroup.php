<?php

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Entity\Constant\ReviewDataDictionary;
use App\Form\MeasureType;
use App\Service\Questionnaire\Questionable;
use App\Service\Review\Reviewable;
use App\Service\Review\ReviewDataCollectable;
use App\Service\Review\ReviewValidator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Table(name: 'experiment_measure')]
#[ORM\Entity]
class MeasureMetaDataGroup extends UuidEntity implements Questionable, Reviewable
{
    /**
     * One basic Information section has One Experiment.
     */
    #[ORM\OneToOne(inversedBy: 'measureMetaDataGroup')]
    protected ?Experiment $experiment = null;

    #[ORM\Column(length: 1500, nullable: true)]
    #[SerializedName('measures')]
    #[Groups(['study'])]
    private ?array $measures = null;

    #[ORM\Column(length: 1500, nullable: true)]
    #[SerializedName('apparatus')]
    #[Groups(['study'])]
    private ?array $apparatus = null;

    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::MEASURES,
                $this->getMeasures(),
                ReviewDataDictionary::MEASURES['errorLevel'] != null && ReviewValidator::validateArrayValues($this->getMeasures())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::APPARATUS,
                $this->getApparatus(),
                ReviewDataDictionary::APPARATUS['errorLevel'] != null && ReviewValidator::validateArrayValues($this->getApparatus())
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
        $this->measures = $measures == null ? null : array_values($measures);
    }

    public function getApparatus(): ?array
    {
        return $this->apparatus;
    }

    public function setApparatus(?array $apparatus): void
    {
        $this->apparatus = $apparatus == null ? null : array_values($apparatus);
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
