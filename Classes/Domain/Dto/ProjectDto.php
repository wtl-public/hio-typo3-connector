<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\LanguageDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\ResearchAreaDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\ResearchAreaKdsfDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\StatusDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\VisibilityDto;
use Wtl\HioTypo3Connector\Domain\Dto\Project\FundingProgramDto;
use Wtl\HioTypo3Connector\Domain\Dto\Project\PersonDto;
use Wtl\HioTypo3Connector\Domain\Dto\Project\ProjectObjectiveDto;
use Wtl\HioTypo3Connector\Domain\Dto\Project\SubjectAreaDto;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithDynamicObjects;
use Wtl\HioTypo3Connector\Trait\WithEndDate;
use Wtl\HioTypo3Connector\Trait\WithLanguage;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;
use Wtl\HioTypo3Connector\Trait\WithStartDate;
use Wtl\HioTypo3Connector\Trait\WithStatus;
use Wtl\HioTypo3Connector\Trait\WithTitle;
use Wtl\HioTypo3Connector\Trait\WithType;
use Wtl\HioTypo3Connector\Trait\WithVisibility;

class ProjectDto
{
    use WithObjectId;
    use WithDetails;
    use WithDynamicObjects;
    use WithEndDate;
    use WithLanguage;
    use WithSearchIndex;
    use WithStartDate;
    use WithStatus;
    use WithTitle;
    use WithType;
    use WithVisibility;

    protected string $abstract = '';
    /**
     * @var FundingProgramDto[]
     */
    protected array $fundingPrograms = [];
    /**
     * @var string[]
     */
    protected array $keywords = [];
    protected ?ProjectObjectiveDto $projectObjective;
    /**
     * @var PersonDto[]
     */
    protected array $persons = [];
    /**
     * @var ResearchAreaDto[]
     */
    protected array $researchAreas = [];
    /**
     * @var ResearchAreaKdsfDto[]
     */
    protected array $researchAreasKdsf = [];
    protected string $shorttext = '';
    /**
     * @var SubjectAreaDto[]
     */
    protected array $subjectAreas = [];
    protected string $uniquename = '';

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

    public function getProjectObjective(): ?ProjectObjectiveDto
    {
        return $this->projectObjective;
    }
    public function setProjectObjective(?ProjectObjectiveDto $projectObjective): void
    {
        $this->projectObjective = $projectObjective;
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

    public function getResearchAreasKdsf(): array
    {
        return $this->researchAreasKdsf;
    }
    public function setResearchAreasKdsf(array $researchAreasKdsf): void
    {
        $this->researchAreasKdsf = $researchAreasKdsf;
    }

    public function getUniquename(): string
    {
        return $this->uniquename;
    }
    public function setUniquename(string $uniquename): void
    {
        $this->uniquename = $uniquename;
    }

    public function getShorttext(): string
    {
        return $this->shorttext;
    }
    public function setShorttext(string $shorttext): void
    {
        $this->shorttext = $shorttext;
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
        $project->setDynamicObjects($data['dynamicObjects'] ?? []);
        if (isset($data['endDate'])) {
            $project->setEndDate(new \DateTime($data['endDate']));
        }
        $project->setLanguage(LanguageDto::fromArray($data['language']) ?? null);
        $project->setProjectObjective(isset($data['projectObjective']) ? ProjectObjectiveDto::fromArray($data['projectObjective']) : null);
        if (isset($data['startDate'])) {
            $project->setStartDate(new \DateTime($data['startDate']));
        }
        $project->setResearchAreas(array_map(fn($item) => ResearchAreaDto::fromArray($item), $data['researchAreas'] ?? []));
        $project->setResearchAreasKdsf(array_map(fn($item) => ResearchAreaKdsfDto::fromArray($item), $data['researchAreasKdfs'] ?? []));
        $project->setShorttext($data['shorttext'] ?? '');
        $project->setStatus(StatusDto::fromArray($data['status']) ?? null);
        $project->setTitle($data['title'] ?? '');
        $project->setType($data['type'] ?? '');
        $project->setUniquename($data['uniquename'] ?? '');
        $project->setVisibility(VisibilityDto::fromArray($data['visibility']) ?? null);

        $members = [];
        foreach ($data['persons'] ?? [] as $person) {
            if (is_array($person)) {
                $members[] = PersonDto::fromArray($person);
            }
        }
        $project->setPersons($members ?? []);
        return $project;
    }
}
