<?php

namespace App\Domain\Model\Administration;

use App\Review\Displayable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

abstract class UuidEntity
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    protected $id;

    use Displayable;

    public function getId()
    {
        return $this->id;
    }

    public function uuidEquals(Uuid $uuid): bool
    {
        return $uuid->equals($this->id);
    }

    public function uuidEqualsString(string $uuid): bool
    {
        return Uuid::fromString($uuid)->equals($this->id);
    }
}
