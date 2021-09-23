<?php

namespace App\Domain\Model\Study;

use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="experiment_basic_creators")
 */
class CreatorMetaDataGroup implements Questionable, Reviewable
{

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator("doctrine.uuid_generator")
     */
    private Uuid $id;

    /**
     * @ORM\Column(type="text", length=100, nullable=true)
     */
    private string $givenName;

    /**
     * @ORM\Column(type="text", length=100, nullable=true)
     */
    private string $familyName;

    /**
     * @ORM\Column(type="text", length=250, nullable=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="text", length=250, nullable=true)
     */
    private string $orcid;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private string $affiliation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Study\BasicInformationMetaDataGroup", inversedBy="creators")
     * @ORM\JoinColumn(name="basic_id", referencedColumnName="id")
     */
    protected BasicInformationMetaDataGroup $basicInformation;

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @param Uuid $id
     */
    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getGivenName(): string
    {
        return $this->givenName;
    }

    /**
     * @param string $givenName
     */
    public function setGivenName(string $givenName): void
    {
        $this->givenName = $givenName;
    }

    /**
     * @return string
     */
    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    /**
     * @param string $familyName
     */
    public function setFamilyName(string $familyName): void
    {
        $this->familyName = $familyName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getAffiliation(): string
    {
        return $this->affiliation;
    }

    /**
     * @return string
     */
    public function getOrcid(): string
    {
        return $this->orcid;
    }

    /**
     * @param string $orcid
     */
    public function setOrcid(string $orcid): void
    {
        $this->orcid = $orcid;
    }

    /**
     * @param string $affiliation
     */
    public function setAffiliation(string $affiliation): void
    {
        $this->affiliation = $affiliation;
    }

    /**
     * @return BasicInformationMetaDataGroup
     */
    public function getBasicInformation(): BasicInformationMetaDataGroup
    {
        return $this->basicInformation;
    }

    /**
     * @param BasicInformationMetaDataGroup $basicInformation
     */
    public function setBasicInformation(BasicInformationMetaDataGroup $basicInformation): void
    {
        $this->basicInformation = $basicInformation;
    }

    public function getFormTypeForEntity(): string
    {
        return CreatorMetaDataGroup::class;
    }

    public function getReviewCollection()
    {
        return [
            ReviewDataCollectable::createFrom('input.creator.name.given', $this->getGivenName(), function () {
                return true;
            }),
            ReviewDataCollectable::createFrom('input.creator.name.family', $this->getFamilyName(), function () {
                return true;
            }),
            ReviewDataCollectable::createFrom('input.creator.email', $this->getEmail(), function () {
                return true;
            }),
            ReviewDataCollectable::createFrom('input.creator.affiliation', $this->getAffiliation(), function () {
                return true;
            }),
        ];
    }
}