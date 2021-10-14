<?php

namespace App\Domain\Model\Study;

use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="experiment_basic_creators")
 */
class CreatorMetaDataGroup extends UuidEntity implements Questionable, Reviewable
{
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
     * @ORM\Column(type="array", nullable=true)
     */
    private array $creditRoles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Study\BasicInformationMetaDataGroup", inversedBy="creators")
     * @ORM\JoinColumn(name="basic_id", referencedColumnName="id")
     */
    protected BasicInformationMetaDataGroup $basicInformation;

    /**
     * @return string
     */
    public function getFormTypeForEntity(): string
    {
        return CreatorMetaDataGroup::class;
    }

    /**
     * @return array
     */
    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom('input.creator.name.given', [$this->getGivenName()]),
            ReviewDataCollectable::createFrom('input.creator.name.family', [$this->getFamilyName()]),
            ReviewDataCollectable::createFrom('input.creator.email', [$this->getEmail()]),
            ReviewDataCollectable::createFrom('input.creator.orcid', [$this->getOrcid()]),
            ReviewDataCollectable::createFrom('input.creator.affiliation', [$this->getAffiliation()]),
            ReviewDataCollectable::createFrom('input.creator.creditRoles', $this->getCreditRoles()),
        ];
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
     * @return array
     */
    public function getCreditRoles(): array
    {
        if (sizeof($this->creditRoles) == 0) {
            $this->creditRoles[] = '';
        }

        return $this->creditRoles;
    }

    /**
     * @param array $creditRoles
     */
    public function setCreditRoles(array $creditRoles): void
    {
        $this->creditRoles = $creditRoles;
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


}