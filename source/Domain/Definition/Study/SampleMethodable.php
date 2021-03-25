<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait SampleMethodable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $sampling_method;

    public function getSamplingMethod()
    {
        return $this->sampling_method;
    }

    public function setSamplingMethod($sampling_method): void
    {
        $this->sampling_method = $sampling_method;
    }
}
