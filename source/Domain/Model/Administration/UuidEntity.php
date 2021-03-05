<?php

namespace App\Domain\Model\Administration;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\UuidV4;

abstract class UuidEntity
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    protected $uuid;

    public function getId()
    {
        return $this->uuid;
    }

    public function uuidEquals(UuidV4 $uuid): bool
    {
        return $uuid->equals($this->uuid);
    }

    public function uuidEqualsString(string $uuid): bool
    {
        return UuidV4::fromString($uuid)->equals($this->uuid);
    }
}