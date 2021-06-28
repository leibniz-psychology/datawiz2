<?php


namespace App\Domain\Definition\Codebook;


use Doctrine\ORM\Mapping as ORM;

trait MetaDatable
{
    /**
     * @var array
     * @ORM\Column(type="json", nullable=true)
     */
    private  $metadata;

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function setMetadata($metadata): void
    {
        $this->metadata = $metadata;
    }
}