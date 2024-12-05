<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO;

use Wtl\HioTypo3Connector\Domain\Model\DTO\Project\ResearchAreaDTO;
use Wtl\HioTypo3Connector\Domain\Model\DTO\Project\SubjectAreaDTO;
use Wtl\HioTypo3Connector\Domain\Model\DTO\Project\PersonDTO;
use Wtl\HioTypo3Connector\Domain\Model\Project;

class ProjectDTO
{
    protected int $extbaseUid = 0;
    protected int $objectId = 0;
    protected array $details = [];

    protected string $title = '';
    protected string $abstract = '';
    protected string $type = '';
    protected string $objective = '';
    protected ?\DateTime $startDate = null;
    protected ?\DateTime $endDate = null;
    /**
     * @var SubjectAreaDTO[]
     */
    protected array $subjectAreas = [];
    /**
     * @var ResearchAreaDTO[]
     */
    protected array $researchAreas = [];
    /**
     * @var PersonDTO[]
     */
    protected array $persons = [];
    protected string $language = '';
    protected string $status = '';
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

    static public function fromDomainModel(Project $model): self
    {
        $details = $model->getDetails();

        $startDate = null;
        if (isset($details['startDate'])) {
            $startDate = \DateTime::createFromFormat(format: 'Y-m-d', datetime: $details['startDate']);
        }
        $endDate = null;
        if (isset($details['endDate'])) {
            $endDate = \DateTime::createFromFormat('Y-m-d', $details['endDate']);
        }

        $subjectAreas = [];
        if (isset($details['subjectAreas'])) {
            foreach ($details['subjectAreas'] as $areaId => $areaName) {
                $subjectAreas[] = SubjectAreaDTO::fromArray(['id' => $areaId, 'name' => $areaName]);
            }
        }

        $researchAreas = [];
        if (isset($details['researchAreas'])) {
            foreach ($details['researchAreas'] as $areaId => $areaName) {
                $researchAreas[] = ResearchAreaDTO::fromArray(['id' => $areaId, 'name' => $areaName]);
            }
        }

        $persons = [];
        if (isset($details['persons'])) {
            foreach ($details['persons'] as $person) {
                $persons[] = PersonDTO::fromArray($person);
            }
        }

        $projectData = new self();
        $projectData->setExtbaseUid($model->getUid());
        $projectData->setDetails($details);
        $projectData->setTitle($details['title']);
        $projectData->setObjectId($details['id']);
        $projectData->setStartDate($startDate);
        $projectData->setEndDate($endDate);
        $projectData->setSubjectAreas($subjectAreas);
        $projectData->setResearchAreas($researchAreas);
        $projectData->setPersons($persons);
        $projectData->setAbstract($details['abstract'] ?? '');
        $projectData->setType($details['type'] ?? '');
        $projectData->setObjective($details['objective'] ?? '');
        $projectData->setLanguage($details['language'] ?? '');
        $projectData->setStatus($details['status'] ?? '');
        $projectData->setVisibility($details['visibility'] ?? '');

        return $projectData;
    }
}
