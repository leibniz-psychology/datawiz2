<?php

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Table(name: 'experiment_method_measurement_instruments')]
#[ORM\Entity]
class MeasurementInstrument extends UuidEntity
{
    #[ORM\ManyToOne(inversedBy: 'measurementInstruments')]
    #[ORM\JoinColumn(name: 'method_id', referencedColumnName: 'id')]
    protected ?MethodMetaDataGroup $method = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('title')]
    #[Groups('study')]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('author')]
    #[Groups('study')]
    private ?string $author = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('citation')]
    #[Groups('study')]
    private ?string $citation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('abstract')]
    #[Groups('study')]
    private ?string $abstract = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('theoretical_background')]
    #[Groups('study')]
    private ?string $theoreticalBackground = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('structure')]
    #[Groups('study')]
    private ?string $structure = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('development')]
    #[Groups('study')]
    private ?string $development = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('objectivity')]
    #[Groups('study')]
    private ?string $objectivity = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('reliability')]
    #[Groups('study')]
    private ?string $reliability = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('validity')]
    #[Groups('study')]
    private ?string $validity = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('norm_referenced')]
    #[Groups('study')]
    private ?string $normReferenced = null;

    public function getMethod(): MethodMetaDataGroup
    {
        return $this->method;
    }

    public function setMethod(?MethodMetaDataGroup $method): void
    {
        $this->method = $method;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }

    public function getCitation(): ?string
    {
        return $this->citation;
    }

    public function setCitation(?string $citation): void
    {
        $this->citation = $citation;
    }

    public function getAbstract(): ?string
    {
        return $this->abstract;
    }

    public function setAbstract(?string $abstract): void
    {
        $this->abstract = $abstract;
    }

    public function getTheoreticalBackground(): ?string
    {
        return $this->theoreticalBackground;
    }

    public function setTheoreticalBackground(?string $theoreticalBackground): void
    {
        $this->theoreticalBackground = $theoreticalBackground;
    }

    public function getStructure(): ?string
    {
        return $this->structure;
    }

    public function setStructure(?string $structure): void
    {
        $this->structure = $structure;
    }

    public function getDevelopment(): ?string
    {
        return $this->development;
    }

    public function setDevelopment(?string $development): void
    {
        $this->development = $development;
    }

    public function getObjectivity(): ?string
    {
        return $this->objectivity;
    }

    public function setObjectivity(?string $objectivity): void
    {
        $this->objectivity = $objectivity;
    }

    public function getReliability(): ?string
    {
        return $this->reliability;
    }

    public function setReliability(?string $reliability): void
    {
        $this->reliability = $reliability;
    }

    public function getValidity(): ?string
    {
        return $this->validity;
    }

    public function setValidity(?string $validity): void
    {
        $this->validity = $validity;
    }

    public function getNormReferenced(): ?string
    {
        return $this->normReferenced;
    }

    public function setNormReferenced(?string $normReferenced): void
    {
        $this->normReferenced = $normReferenced;
    }
}
