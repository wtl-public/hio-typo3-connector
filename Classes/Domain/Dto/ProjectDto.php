<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Domain\Dto\Project\PersonDto;
use Wtl\HioTypo3Connector\Domain\Dto\Project\ResearchAreaDto;
use Wtl\HioTypo3Connector\Domain\Dto\Project\SubjectAreaDto;

class ProjectDto
{
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;

    protected string $title = '';
    protected string $abstract = '';
    protected string $type = '';
    protected string $objective = '';
    protected ?\DateTime $startDate = null;
    protected ?\DateTime $endDate = null;
    /**
     * @var SubjectAreaDto[]
     */
    protected array $subjectAreas = [];
    /**
     * @var ResearchAreaDto[]
     */
    protected array $researchAreas = [];
    /**
     * @var PersonDto[]
     */
    protected array $persons = [];
    protected string $language = '';
    protected string $status = '';
    protected string $visibility = '';

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAbstract(): string
    {
        return $this->abstract;
    }

    public function setAbstract(string $abstract): void
    {
        $this->abstract = $abstract;
    }

    public function getType(): string
    {
        return $this->type;
    }
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getObjective(): string
    {
        return $this->objective;
    }
    public function setObjective(string $objective): void
    {
        $this->objective = $objective;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }
    public function setLanguage(string $language): void
    {
        $this->language = $language;
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

    public function getStartDate(): \DateTime|null
    {
        return $this->startDate;
    }
    public function setStartDate(?\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): \DateTime|null
    {
        return $this->endDate;
    }
    public function setEndDate(?\DateTime $endDate): void
    {
        $this->endDate = $endDate;
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
}
