<?php


namespace App\Domain\Definition\Study;


use Doctrine\ORM\Mapping as ORM;

trait Hypothesable
{
    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private $hypothesis;

    public function getHypothesis()
    {
        return $this->hypothesis;
    }

    public function setHypothesis($hypothesis): void
    {
        $this->hypothesis = $hypothesis;
    }
}