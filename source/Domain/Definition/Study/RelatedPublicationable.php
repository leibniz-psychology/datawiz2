<?php


namespace App\Domain\Definition\Study;


use Doctrine\ORM\Mapping as ORM;

trait RelatedPublicationable
{
    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $related_publications;

    public function getRelatedPublications()
    {
        return $this->related_publications;
    }

    public function setRelatedPublications($related_publications): void
    {
        $this->related_publications = $related_publications;
    }

    private static function getRelatedPublicationOptions(): array
    {
        return [
            'label' => 'Related publications',
            'help' => 'Any publications that refers to the subject of your study'
        ];
    }

}