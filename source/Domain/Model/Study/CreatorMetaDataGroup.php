<?php

namespace App\Domain\Model\Study;

use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use App\Review\ReviewValidator;
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
    private ?string $givenName = null;

    /**
     * @ORM\Column(type="text", length=100, nullable=true)
     */
    private ?string $familyName = null;

    /**
     * @ORM\Column(type="text", length=250, nullable=true)
     */
    private ?string $email = null;

    /**
     * @ORM\Column(type="text", length=250, nullable=true)
     */
    private ?string $orcid = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     */
    private ?string $affiliation = null;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private ?array $creditRoles = null;

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
            ReviewDataCollectable::createFrom(
                'input.creator.name.given',
                [$this->getGivenName()],
                ReviewValidator::validateSingleValue($this->getGivenName(), 'input.creator.empty.given')
            ),
            ReviewDataCollectable::createFrom(
                'input.creator.name.family',
                [$this->getFamilyName()],
                ReviewValidator::validateSingleValue($this->getFamilyName(), 'input.creator.empty.family')
            ),
            ReviewDataCollectable::createFrom(
                'input.creator.email',
                [$this->getEmail()],
                ReviewValidator::validateSingleValue($this->getEmail(), 'input.creator.empty.email')
            ),
            ReviewDataCollectable::createFrom(
                'input.creator.orcid',
                [$this->getOrcid()],
                ReviewValidator::validateSingleValue($this->getOrcid(), 'input.creator.empty.orcid')
            ),
            ReviewDataCollectable::createFrom(
                'input.creator.affiliation',
                [$this->getAffiliation()],
                ReviewValidator::validateSingleValue($this->getAffiliation(), 'input.creator.empty.affiliation')
            ),
            ReviewDataCollectable::createFrom(
                'input.creator.roles',
                $this->getCreditRoles(),
                ReviewValidator::validateArrayValues($this->getCreditRoles(), 'input.creator.empty.roles')
            ),
        ];
    }

    /**
     * @return string|null
     */
    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    /**
     * @param string|null $givenName
     */
    public function setGivenName(?string $givenName): void
    {
        $this->givenName = $givenName;
    }

    /**
     * @return string|null
     */
    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    /**
     * @param string|null $familyName
     */
    public function setFamilyName(?string $familyName): void
    {
        $this->familyName = $familyName;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getOrcid(): ?string
    {
        return $this->orcid;
    }

    /**
     * @param string|null $orcid
     */
    public function setOrcid(?string $orcid): void
    {
        $this->orcid = $orcid;
    }

    /**
     * @return string|null
     */
    public function getAffiliation(): ?string
    {
        return $this->affiliation;
    }

    /**
     * @param string|null $affiliation
     */
    public function setAffiliation(?string $affiliation): void
    {
        $this->affiliation = $affiliation;
    }

    /**
     * @return null|array
     */
    public function getCreditRoles(): ?array
    {
        if (null === $this->creditRoles) {
            $this->creditRoles = array('');
        }

        return $this->creditRoles;
    }

    /**
     * @param array|null $creditRoles
     */
    public function setCreditRoles(?array $creditRoles): void
    {
        $this->creditRoles = null == $creditRoles ? null : array_values($creditRoles);
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