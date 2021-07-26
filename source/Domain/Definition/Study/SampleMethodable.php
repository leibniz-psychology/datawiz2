<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait SampleMethodable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $sampling_method;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $other_sampling_method;

    public function getSamplingMethod()
    {
        if ($this->sampling_method === "Others") {
            return $this->other_sampling_method;
        }

        return $this->sampling_method;
    }

    public function setSamplingMethod($sampling_method): void
    {
        $this->sampling_method = $sampling_method;
    }

    public function getOtherSamplingMethod()
    {
        return $this->other_sampling_method;
    }

    public function setOtherSamplingMethod($other_sampling_method): void
    {
        $this->other_sampling_method = $other_sampling_method;
    }

}
