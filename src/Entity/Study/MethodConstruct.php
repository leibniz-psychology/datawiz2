<?php

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Enum\Study\ConstructFunction;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Table(name: 'experiment_method_constructs')]
#[ORM\Entity]
class MethodConstruct extends UuidEntity
{
    #[ORM\ManyToOne(inversedBy: 'constructs')]
    #[ORM\JoinColumn(name: 'method_id', referencedColumnName: 'id')]
    protected ?MethodMetaDataGroup $method = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('name')]
    #[Groups('study')]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('function')]
    #[Groups('study')]
    private ?ConstructFunction $constructFunction = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('other_function_description')]
    #[Groups('study')]
    private ?string $otherFunctionDescription = null;

    public function getMethod(): MethodMetaDataGroup
    {
        return $this->method;
    }

    public function setMethod(?MethodMetaDataGroup $method): void
    {
        $this->method = $method;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getConstructFunction(): ?ConstructFunction
    {
        return $this->constructFunction;
    }

    public function setConstructFunction(?ConstructFunction $constructFunction): static
    {
        $this->constructFunction = $constructFunction;
        return $this;
    }

    public function getOtherFunctionDescription(): ?string
    {
        return $this->otherFunctionDescription;
    }

    public function setOtherFunctionDescription(?string $otherFunctionDescription): static
    {
        $this->otherFunctionDescription = $otherFunctionDescription;
        return $this;
    }
}
