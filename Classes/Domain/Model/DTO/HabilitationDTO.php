<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO;

use Wtl\HioTypo3Connector\Domain\Model\DTO\Habilitation\OrganizationDTO;
use Wtl\HioTypo3Connector\Domain\Model\DTO\Habilitation\PersonDTO;
use Wtl\HioTypo3Connector\Domain\Model\Habilitation;

class HabilitationDTO extends BaseDTO
{
    protected ?\DateTime $admissionDate = null;
    protected ?\DateTime $certificateDate = null;
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
    protected ?\DateTime $registrationDate = null;
    /**
     * @var string[]
     */
    protected array $researchAreas = [];
    protected ?\DateTime $startDate = null;
    protected string $status = '';
    protected array $subjectAreas = [];
    protected string $title = '';
    protected string $type = '';

    public function getAdmissionDate(): ?\DateTime
    {
        return $this->admissionDate;
    }
    public function setAdmissionDate(?\DateTime $admissionDate): void
    {
        $this->admissionDate = $admissionDate;
    }

    public function getCertificateDate(): ?\DateTime
    {
        return $this->certificateDate;
    }
    public function setCertificateDate(?\DateTime $certificateDate): void
    {
        $this->certificateDate = $certificateDate;
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

    public function getOrganizations(): array
    {
        return $this->organizations;
    }
    public function setOrganizations(array $organizations): void
    {
        $this->organizations = $organizations;
    }

    public function getPersons(): array
    {
        return $this->persons;
    }
    public function setPersons(array $persons): void
    {
        $this->persons = $persons;
    }

    public function getRegistrationDate(): ?\DateTime
    {
        return $this->registrationDate;
    }
    public function setRegistrationDate(?\DateTime $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }

    public function getResearchAreas(): array
    {
        return $this->researchAreas;
    }
    public function setResearchAreas(array $researchAreas): void
    {
        $this->researchAreas = $researchAreas;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }
    public function setStartDate(?\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getSubjectAreas(): array
    {
        return $this->subjectAreas;
    }
    public function setSubjectAreas(array $subjectAreas): void
    {
        $this->subjectAreas = $subjectAreas;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getType(): string
    {
        return $this->type;
    }
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    static public function fromDomainModel(Habilitation|\TYPO3\CMS\Extbase\DomainObject\AbstractEntity $model): static
    {
        $details = $model->getDetails();

        $admissionDate = null;
        if (isset($details['admissionDate'])) {
            $admissionDate = \DateTime::createFromFormat(format: 'Y-m-d', datetime: $details['admissionDate']);
        }
        $certificateDate = null;
        if (isset($details['certificateDate'])) {
            $certificateDate = \DateTime::createFromFormat(format: 'Y-m-d', datetime: $details['certificateDate']);
        }
        $endDate = null;
        if (isset($details['endDate'])) {
            $endDate = \DateTime::createFromFormat(format: 'Y-m-d', datetime: $details['endDate']);
        }
        $registrationDate = null;
        if (isset($details['registrationDate'])) {
            $registrationDate = \DateTime::createFromFormat(format: 'Y-m-d', datetime: $details['registrationDate']);
        }
        $startDate = null;
        if (isset($details['startDate'])) {
            $startDate = \DateTime::createFromFormat(format: 'Y-m-d', datetime: $details['startDate']);
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
        $dto->setAdmissionDate($admissionDate);
        $dto->setCertificateDate($certificateDate);
        $dto->setEndDate($endDate);
        $dto->setLanguage($details['language'] ?? '');
        $dto->setOrganizations($organizations);
        $dto->setPersons($persons);
        $dto->setRegistrationDate($registrationDate);
        $dto->setResearchAreas($details['researchAreas'] ?? []);
        $dto->setStartDate($startDate);
        $dto->setStatus($details['status'] ?? '');
        $dto->setSubjectAreas($details['subjectAreas'] ?? []);
        $dto->setTitle($details['title']);
        $dto->setType($details['type'] ?? '');

        return $dto;
    }
}
