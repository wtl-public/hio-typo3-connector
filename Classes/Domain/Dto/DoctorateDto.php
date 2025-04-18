<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Domain\Dto\Doctorate\OrganizationDto;
use Wtl\HioTypo3Connector\Domain\Dto\Doctorate\PersonDto;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;

class DoctorateDto
{
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;

    protected string $courseOfStudy = '';
    protected string $description = '';
    protected bool $doctoralPositionAvailable = false;
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
    /**
     * @var string[]
     */
    protected array $researchAreas = [];
    protected bool $scholarshipAvailable = false;
    protected ?\DateTime $startDate = null;

    protected array $subjectAreas = [];
    protected string $title = '';

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
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
}
