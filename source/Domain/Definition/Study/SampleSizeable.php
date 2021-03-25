<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait SampleSizeable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $sample_size;

    public function getSampleSize()
    {
        return $this->sample_size;
    }

    public function setSampleSize($sample_size): void
    {
        $this->sample_size = $sample_size;
    }
}
