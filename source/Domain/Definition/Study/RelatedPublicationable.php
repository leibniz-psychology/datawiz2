<?php

namespace App\Domain\Definition\Study;

use App\Domain\Definition\MetaDataDictionary;
use Doctrine\ORM\Mapping as ORM;

trait RelatedPublicationable
{
    /**
     * @ORM\Column(type="array", length=1500, nullable=true)
     * @var $related_publications array
     */
    private $related_publications;

    public function getRelatedPublications(): ?array
    {
        if ($this->related_publications === null) {
            $this->related_publications = array('');
        }
        return $this->related_publications;
    }

    public function setRelatedPublications(array $related_publications): void
    {
        $this->related_publications = $related_publications;
    }
}
