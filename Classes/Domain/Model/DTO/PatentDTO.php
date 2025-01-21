<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO;

use Wtl\HioTypo3Connector\Domain\Model\DTO\Patent\InventorDTO;
use Wtl\HioTypo3Connector\Domain\Model\Patent;

class PatentDTO
{
    protected int $extbaseUid = 0;
    protected int $objectId = 0;
    protected array $details = [];

    protected string $countryOfRegistration = '';
    protected string $description = '';
    protected ?\DateTime $grantDate = null;
    /**
     * @var InventorDTO[]
     */
    protected array $inventors = [];
    protected string $patentNumber = '';
    protected ?bool $priorityPatent = null;
    protected ?string $publicationNumber = null;

    protected ?\DateTime $registrationDate = null;
    /**
     * @var string[]
     */
    protected array $researchAreas = [];
    protected string $status = '';
    /**
     * @var string[]
     */
    protected array $subjectAreas = [];
    protected string $title = '';
    protected string $visibility = '';

    public function getExtbaseUid(): int
    {
        return $this->extbaseUid;
    }
    public function setExtbaseUid(int $extbaseUid): void
    {
        $this->extbaseUid = $extbaseUid;
    }

    public function getObjectId(): int
    {
        return $this->objectId;
    }
    public function setObjectId($objectId): void
    {
        $this->objectId = $objectId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDetails(): array
    {
        return $this->details;
    }
    public function setDetails(array $details): void
    {
        $this->details = $details;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getVisibility(): string
    {
        return $this->visibility;
    }
    public function setVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
    }

    public function getSubjectAreas(): array
    {
        return $this->subjectAreas;
    }
    public function setSubjectAreas(array $subjectAreas): void
    {
        $this->subjectAreas = $subjectAreas;
    }

    public function getResearchAreas(): array
    {
        return $this->researchAreas;
    }
    public function setResearchAreas(array $researchAreas): void
    {
        $this->researchAreas = $researchAreas;
    }

    public function getInventors(): array
    {
        return $this->inventors;
    }
    public function setInventors(array $inventors): void
    {
        $this->inventors = $inventors;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPatentNumber(): string
    {
        return $this->patentNumber;
    }

    public function setPatentNumber(string $patentNumber): void
    {
        $this->patentNumber = $patentNumber;
    }

    public function getPriorityPatent(): ?bool
    {
        return $this->priorityPatent;
    }

    public function setPriorityPatent(?bool $priorityPatent): void
    {
        $this->priorityPatent = $priorityPatent;
    }

    public function getCountryOfRegistration(): string
    {
        return $this->countryOfRegistration;
    }

    public function setCountryOfRegistration(string $countryOfRegistration): void
    {
        $this->countryOfRegistration = $countryOfRegistration;
    }

    public function getPublicationNumber(): ?string
    {
        return $this->publicationNumber;
    }
    public function setPublicationNumber(?string $publicationNumber): void
    {
        $this->publicationNumber = $publicationNumber;
    }

    public function getGrantDate(): ?\DateTime
    {
        return $this->grantDate;
    }
    public function setGrantDate(?\DateTime $grantDate): void
    {
        $this->grantDate = $grantDate;
    }

    public function getRegistrationDate(): ?\DateTime
    {
        return $this->registrationDate;
    }
    public function setRegistrationDate(?\DateTime $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }

    static public function fromDomainModel(Patent $model): self
    {
        $details = $model->getDetails();

        $grantDate = null;
        if (isset($details['grantDate'])) {
            $grantDate = \DateTime::createFromFormat(format: 'Y-m-d', datetime: $details['grantDate']);
        }
        $registrationDate = null;
        if (isset($details['registrationDate'])) {
            $registrationDate = \DateTime::createFromFormat('Y-m-d', $details['registrationDate']);
        }

        $inventors = [];
        if (isset($details['inventors'])) {
            foreach ($details['inventors'] as $inventor) {
                $inventors[] = InventorDTO::fromArray($inventor);
            }
        }

        $patentData = new self();
        $patentData->setExtbaseUid($model->getUid());
        $patentData->setObjectId($details['id']);
        $patentData->setDetails($details);

        $patentData->setCountryOfRegistration($details['countryOfRegistration'] ?? '');
        $patentData->setDescription($details['description'] ?? '');
        $patentData->setGrantDate($grantDate);
        $patentData->setInventors($inventors);
        $patentData->setPatentNumber($details['patentNumber'] ?? '');
        $patentData->setPriorityPatent($details['priorityPatent'] ?? null);
        $patentData->setPublicationNumber($details['publicationNumber'] ?? null);
        $patentData->setRegistrationDate($registrationDate);
        $patentData->setResearchAreas($details['researchAreas'] ?? []);
        $patentData->setStatus($details['status'] ?? '');
        $patentData->setSubjectAreas($details['subjectAreas'] ?? []);
        $patentData->setTitle($details['title']);
        $patentData->setVisibility($details['visibility'] ?? '');

        return $patentData;
    }
}
