<?php

namespace App\Entity\Study;

use App\Entity\Administration\UuidEntity;
use App\Entity\Constant\ReviewDataDictionary;
use App\Service\Questionnaire\Questionable;
use App\Service\Review\Reviewable;
use App\Service\Review\ReviewDataCollectable;
use App\Service\Review\ReviewValidator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Table(name: 'experiment_basic_creators')]
#[ORM\Entity]
class CreatorMetaDataGroup extends UuidEntity implements Questionable, Reviewable
{
    #[ORM\ManyToOne(inversedBy: 'creators')]
    #[ORM\JoinColumn(name: 'basic_id', referencedColumnName: 'id')]
    protected ?BasicInformationMetaDataGroup $basicInformation = null;
    #[ORM\Column(type: 'text', length: 100, nullable: true)]
    #[SerializedName('given_name')]
    #[Groups('study')]
    private ?string $givenName = null;

    #[ORM\Column(type: 'text', length: 100, nullable: true)]
    #[SerializedName('family_name')]
    #[Groups('study')]
    private ?string $familyName = null;

    #[ORM\Column(type: 'text', length: 250, nullable: true)]
    #[SerializedName('email')]
    #[Groups('study')]
    private ?string $email = null;

    #[ORM\Column(type: 'text', length: 250, nullable: true)]
    #[SerializedName('orcid')]
    #[Groups('study')]
    private ?string $orcid = null;

    #[ORM\Column(type: 'text', length: 1500, nullable: true)]
    #[SerializedName('affiliation')]
    #[Groups('study')]
    private ?string $affiliation = null;

    #[ORM\Column(type: 'json', nullable: true)]
    #[SerializedName('roles')]
    #[Groups('study')]
    private ?array $creditRoles = null;

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
                ReviewDataDictionary::CREATOR_GIVEN['errorLevel'] != null && ReviewValidator::validateSingleValue($this->getGivenName())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::CREATOR_FAMILY,
                [$this->getFamilyName()],
                ReviewDataDictionary::CREATOR_FAMILY['errorLevel'] != null && ReviewValidator::validateSingleValue($this->getFamilyName())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::CREATOR_EMAIL,
                [$this->getEmail()],
                ReviewDataDictionary::CREATOR_EMAIL['errorLevel'] != null && ReviewValidator::validateSingleValue($this->getEmail())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::CREATOR_ORCID,
                [$this->getOrcid()],
                ReviewDataDictionary::CREATOR_ORCID['errorLevel'] != null && ReviewValidator::validateSingleValue($this->getOrcid())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::CREATOR_AFFILIATION,
                [$this->getAffiliation()],
                ReviewDataDictionary::CREATOR_AFFILIATION['errorLevel'] != null && ReviewValidator::validateSingleValue($this->getAffiliation())
            ),
            ReviewDataCollectable::createFrom(
                ReviewDataDictionary::CREATOR_ROLES,
                $this->getCreditRoles(),
                ReviewDataDictionary::CREATOR_ROLES['errorLevel'] != null && ReviewValidator::validateArrayValues($this->getCreditRoles())
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
        if ($this->creditRoles === null) {
            $this->creditRoles = [''];
        }

        return $this->creditRoles;
    }

    public function setCreditRoles(?array $creditRoles): void
    {
        $this->creditRoles = $creditRoles == null ? null : array_values($creditRoles);
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
