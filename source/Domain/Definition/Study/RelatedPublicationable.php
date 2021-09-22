<?php

namespace App\Domain\Definition\Study;

use Doctrine\ORM\Mapping as ORM;

trait RelatedPublicationable
{
    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     * @var $related_publications array|null
     */
    private ?array $related_publications = null;

    public function getRelatedPublications(): ?array
    {
        if ($this->related_publications === null) {
            $this->related_publications = array('');
        }

        return array_values($this->related_publications);
    }

    public function setRelatedPublications(?array $related_publications): void
    {
        $this->related_publications = array_values($related_publications);
    }
}
