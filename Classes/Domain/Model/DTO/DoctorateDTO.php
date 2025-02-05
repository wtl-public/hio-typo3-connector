<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO;

use Wtl\HioTypo3Connector\Domain\Model\DTO\Doctorate\OrganizationDTO;
use Wtl\HioTypo3Connector\Domain\Model\DTO\Doctorate\PersonDTO;
use Wtl\HioTypo3Connector\Domain\Model\Doctorate;

class DoctorateDTO
{
    protected int $extbaseUid = 0;
    protected int $objectId = 0;
    protected array $details = [];

    protected string $courseOfStudy = '';
    protected string $description = '';
    protected bool $doctoralPositionAvailable = false;
    protected ?\DateTime $endDate = null;
    protected string $language = '';

    /**
     * @var OrganizationDTO[]
     */
    protected array $organizations = [];
    /**
     * @var PersonDTO[]
     */
    protected array $persons = [];
    /**
     * @var string[]
     */
    protected array $researchAreas = [];
    protected bool $scholarshipAvailable = false;
    protected ?\DateTime $startDate = null;

    protected array $subjectAreas = [];
    protected string $title = '';

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

    public function getCourseOfStudy(): string
    {
        return $this->courseOfStudy;
    }
    public function setCourseOfStudy(string $courseOfStudy): void
    {
        $this->courseOfStudy = $courseOfStudy;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDoctoralPositionAvailable(): bool
    {
        return $this->doctoralPositionAvailable;
    }
    public function setDoctoralPositionAvailable(bool $doctoralPositionAvailable): void
    {
        $this->doctoralPositionAvailable = $doctoralPositionAvailable;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }
    public function setEndDate(?\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }
    public function setLanguage(string $language): void
    {
        $this->language = $language;
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

    public function getPersons(): array
    {
        return $this->persons;
    }
    public function setPersons(array $persons): void
    {
        $this->persons = $persons;
    }

    public function getOrganizations(): array
    {
        return $this->organizations;
    }
    public function setOrganizations(array $organizations): void
    {
        $this->organizations = $organizations;
    }

    public function getScholarshipAvailable(): bool
    {
        return $this->scholarshipAvailable;
    }
    public function setScholarshipAvailable(bool $scholarshipAvailable): void
    {
        $this->scholarshipAvailable = $scholarshipAvailable;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }
    public function setStartDate(?\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    static public function fromDomainModel(Doctorate $model): self
    {
        $details = $model->getDetails();

        $startDate = null;
        if (isset($details['startDate'])) {
            $startDate = \DateTime::createFromFormat(format: 'Y-m-d', datetime: $details['startDate']);
        }
        $endDate = null;
        if (isset($details['endDate'])) {
            $endDate = \DateTime::createFromFormat(format: 'Y-m-d', datetime: $details['endDate']);
        }

        $persons = [];
        if (isset($details['persons'])) {
            foreach ($details['persons'] as $person) {
                $persons[] = PersonDTO::fromArray($person);
            }
        }
        $organizations = [];
        if (isset($details['organizations'])) {
            foreach ($details['organizations'] as $organization) {
                $organizations[] = OrganizationDTO::fromArray($organization);
            }
        }

        $dto = new self();
        $dto->setExtbaseUid($model->getUid());
        $dto->setObjectId($details['id']);
        $dto->setDetails($details);

        $dto->setCourseOfStudy($details['courseOfStudy'] ?? '');
        $dto->setDescription($details['description'] ?? '');
        $dto->setDoctoralPositionAvailable($details['doctoralPositionAvailable'] ?? false);
        $dto->setEndDate($endDate);
        $dto->setLanguage($details['language'] ?? '');
        $dto->setOrganizations($organizations);
        $dto->setPersons($persons);
        $dto->setResearchAreas($details['researchAreas'] ?? []);
        $dto->setScholarshipAvailable($details['scholarshipAvailable'] ?? false);
        $dto->setStartDate($startDate);
        $dto->setSubjectAreas($details['subjectAreas'] ?? []);
        $dto->setTitle($details['title']);

        return $dto;
    }
}
