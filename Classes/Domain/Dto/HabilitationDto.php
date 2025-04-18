<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Domain\Dto\Collection\OrganizationDto;
use Wtl\HioTypo3Connector\Domain\Dto\Collection\PersonDto;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;

class HabilitationDto
{
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;

    protected ?\DateTime $admissionDate = null;
    protected ?\DateTime $certificateDate = null;
    protected ?\DateTime $endDate = null;

    protected string $language = '';
    /**
     * @var OrganizationDto[]
     */
    protected array $organizations = [];
    /**
     * @var PersonDto[]
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

    static public function fromArray(array $data): HabilitationDto
    {
        $habilitationDto = new self();
        $habilitationDto->setObjectId($data['id']);
        $habilitationDto->setDetails($data);
        $habilitationDto->setSearchIndex($data);

        if (isset($data['admissionDate'])) {
            $habilitationDto->setAdmissionDate(new \DateTime($data['admissionDate']));
        }
        if (isset($data['certificateDate'])) {
            $habilitationDto->setCertificateDate(new \DateTime($data['certificateDate']));
        }
        if (isset($data['endDate'])) {
            $habilitationDto->setEndDate(new \DateTime($data['endDate']));
        }
        $habilitationDto->setPersons(array_map(fn($item) => PersonDto::fromArray($item), $data['persons'] ?? []));
        if (isset($data['registrationDate'])) {
            $habilitationDto->setRegistrationDate(new \DateTime($data['registrationDate']));
        }
        if (isset($data['startDate'])) {
            $habilitationDto->setStartDate(new \DateTime($data['startDate']));
        }
        $habilitationDto->setTitle($data['title']);
        $habilitationDto->setType($data['type']);

        return $habilitationDto;
    }
}
