<?php

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Table(name: 'experiment_method_measurement_occasions')]
#[ORM\Entity]
class MeasurementOccasion extends UuidEntity
{
    #[ORM\ManyToOne(inversedBy: 'measurementOccasions')]
    #[ORM\JoinColumn(name: 'method_id', referencedColumnName: 'id')]
    protected ?MethodMetaDataGroup $method = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('time_of_measurement')]
    #[Groups('study')]
    private ?string $timeOfMeasurement = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('intervention')]
    #[Groups('study')]
    private ?bool $intervention = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('position')]
    #[Groups('study')]
    private ?int $position = null;

    public function getMethod(): MethodMetaDataGroup
    {
        return $this->method;
    }

    public function setMethod(?MethodMetaDataGroup $method): void
    {
        $this->method = $method;
    }

    public function getTimeOfMeasurement(): ?string
    {
        return $this->timeOfMeasurement;
    }

    public function setTimeOfMeasurement(?string $timeOfMeasurement): void
    {
        $this->timeOfMeasurement = $timeOfMeasurement;
    }

    public function getIntervention(): ?bool
    {
        return $this->intervention;
    }

    public function setIntervention(?bool $intervention): void
    {
        $this->intervention = $intervention;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }
}
