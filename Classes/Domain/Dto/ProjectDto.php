<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Domain\Dto\Project\FundingProgramDto;
use Wtl\HioTypo3Connector\Domain\Dto\Project\PersonDto;
use Wtl\HioTypo3Connector\Domain\Dto\Project\ResearchAreaDto;
use Wtl\HioTypo3Connector\Domain\Dto\Project\SubjectAreaDto;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;

class ProjectDto
{
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;

    protected string $abstract = '';
    protected ?\DateTime $endDate = null;
    /**
     * @var FundingProgramDto[]
     */
    protected array $fundingPrograms = [];
    /**
     * @var string[]
     */
    protected array $keywords = [];
    protected string $language = '';
    protected string $objective = '';
    /**
     * @var PersonDto[]
     */
    protected array $persons = [];
    /**
     * @var ResearchAreaDto[]
     */
    protected array $researchAreas = [];
    protected ?\DateTime $startDate = null;
    /**
     * @var SubjectAreaDto[]
     */
    protected string $status = '';
    protected array $subjectAreas = [];
    protected string $title = '';
    protected string $type = '';
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

    public function getFundingPrograms(): array
    {
        return $this->fundingPrograms;
    }
    public function setFundingPrograms(array $fundingPrograms): void
    {
        $this->fundingPrograms = $fundingPrograms;
    }

    public function getKeywords(): array
    {
        return $this->keywords;
    }
    public function setKeywords(array $keywords): void
    {
        $this->keywords = $keywords;
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

    static public function fromArray(array $data): ProjectDto
    {
        $project = new self();
        $project->setObjectId($data['id']);
        $project->setDetails($data);
        $project->setSearchIndex($data);

        $project->setAbstract($data['abstract'] ?? '');
        if (isset($data['endDate'])) {
            $project->setEndDate(new \DateTime($data['endDate']));
        }
        $project->setLanguage($data['language'] ?? '');
        $project->setObjective($data['objective'] ?? '');
        if (isset($data['startDate'])) {
            $project->setStartDate(new \DateTime($data['startDate']));
        }
        $project->setStatus($data['status'] ?? '');
        $project->setTitle($data['title'] ?? '');
        $project->setType($data['type'] ?? '');
        $project->setVisibility($data['visibility'] ?? '');

        return $project;
    }
}
