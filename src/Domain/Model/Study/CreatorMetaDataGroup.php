<?php

namespace App\Domain\Model\Study;

use App\Domain\Definition\ReviewDataDictionary;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Questionable;
use App\Review\Reviewable;
use App\Review\ReviewDataCollectable;
use App\Review\ReviewValidator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity
 * @ORM\Table(name="experiment_basic_creators")
 */
class CreatorMetaDataGroup extends UuidEntity implements Questionable, Reviewable
{
    /**
     * @ORM\Column(type="text", length=100, nullable=true)
     * @SerializedName("given_name")
     * @Groups("study")
     */
    private ?string $givenName = null;

    /**
     * @ORM\Column(type="text", length=100, nullable=true)
     * @SerializedName("family_name")
     * @Groups("study")
     */
    private ?string $familyName = null;

    /**
     * @ORM\Column(type="text", length=250, nullable=true)
     * @SerializedName("email")
     * @Groups("study")
     */
    private ?string $email = null;

    /**
     * @ORM\Column(type="text", length=250, nullable=true)
     * @SerializedName("orcid")
     * @Groups("study")
     */
    private ?string $orcid = null;

    /**
     * @ORM\Column(type="text", length=1500, nullable=true)
     * @SerializedName("affiliation")
     * @Groups("study")
     */
    private ?string $affiliation = null;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @SerializedName("roles")
     * @Groups("study")
     */
    private ?array $creditRoles = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Study\BasicInformationMetaDataGroup", inversedBy="creators")
     * @ORM\JoinColumn(name="basic_id", referencedColumnName="id")
     */
    protected BasicInformationMetaDataGroup $basicInformation;

    public function getFormTypeForEntity(): string
    {
        return CreatorMetaDataGroup::class;
    }

    public function getReviewCollection(): array
    {
        return [
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::CREATOR_GIVEN,
                [$this->getGivenName()],
                null != ReviewDataDictionary::CREATOR_GIVEN['errorLevel'] && ReviewValidator::validateSingleValue($this->getGivenName())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::CREATOR_FAMILY,
                [$this->getFamilyName()],
                null != ReviewDataDictionary::CREATOR_FAMILY['errorLevel'] && ReviewValidator::validateSingleValue($this->getFamilyName())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::CREATOR_EMAIL,
                [$this->getEmail()],
                null != ReviewDataDictionary::CREATOR_EMAIL['errorLevel'] && ReviewValidator::validateSingleValue($this->getEmail())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::CREATOR_ORCID,
                [$this->getOrcid()],
                null != ReviewDataDictionary::CREATOR_ORCID['errorLevel'] && ReviewValidator::validateSingleValue($this->getOrcid())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::CREATOR_AFFILIATION,
                [$this->getAffiliation()],
                null != ReviewDataDictionary::CREATOR_AFFILIATION['errorLevel'] && ReviewValidator::validateSingleValue($this->getAffiliation())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::CREATOR_ROLES,
                $this->getCreditRoles(),
                null != ReviewDataDictionary::CREATOR_ROLES['errorLevel'] && ReviewValidator::validateArrayValues($this->getCreditRoles())
            ),
        ];
    }

    public function isEmpty(): bool
    {
        return empty($this->getFamilyName()) && empty($this->getGivenName()) && empty($this->getEmail());
    }

    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function setGivenName(?string $givenName): void
    {
        $this->givenName = $givenName;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setFamilyName(?string $familyName): void
    {
        $this->familyName = $familyName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getOrcid(): ?string
    {
        return $this->orcid;
    }

    public function setOrcid(?string $orcid): void
    {
        $this->orcid = $orcid;
    }

    public function getAffiliation(): ?string
    {
        return $this->affiliation;
    }

    public function setAffiliation(?string $affiliation): void
    {
        $this->affiliation = $affiliation;
    }

    public function getCreditRoles(): ?array
    {
        if (null === $this->creditRoles) {
            $this->creditRoles = [''];
        }

        return $this->creditRoles;
    }

    public function setCreditRoles(?array $creditRoles): void
    {
        $this->creditRoles = null == $creditRoles ? null : array_values($creditRoles);
    }

    public function getBasicInformation(): BasicInformationMetaDataGroup
    {
        return $this->basicInformation;
    }

    public function setBasicInformation(BasicInformationMetaDataGroup $basicInformation): void
    {
        $this->basicInformation = $basicInformation;
    }


}