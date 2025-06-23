<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Wtl\HioTypo3Connector\Domain\Dto\Collection\DoctoralProgramDto;
use Wtl\HioTypo3Connector\Domain\Dto\Collection\HabilitationDto;
use Wtl\HioTypo3Connector\Domain\Dto\Collection\OrgUnitDto;
use Wtl\HioTypo3Connector\Domain\Dto\Collection\PatentDto;
use Wtl\HioTypo3Connector\Domain\Dto\Collection\ProjectDto;
use Wtl\HioTypo3Connector\Domain\Dto\Collection\PublicationDto;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;

class PersonDto
{
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;

    protected string $name = '';

    protected array $doctoralPrograms = [];
    protected array $habilitations = [];
    protected array $patents = [];
    protected array $projects = [];
    protected array $publications = [];
    protected array $orgUnits = [];

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPublications(): array
    {
        return $this->publications;
    }

    public function setPublications(array $publications): void
    {
        $this->publications = $publications;
    }

    public function getProjects(): array
    {
        return $this->projects;
    }
    public function setProjects(array $projects): void
    {
        $this->projects = $projects;
    }

    public function getPatents(): array
    {
        return $this->patents;
    }
    public function setPatents(array $patents): void
    {
        $this->patents = $patents;
    }

    public function getDoctoralPrograms(): array
    {
        return $this->doctoralPrograms;
    }
    public function setDoctoralPrograms(array $doctoralPrograms): void
    {
        $this->doctoralPrograms = $doctoralPrograms;
    }

    public function getHabilitations(): array
    {
        return $this->habilitations;
    }
    public function setHabilitations(array $habilitations): void
    {
        $this->habilitations = $habilitations;
    }

    public function getOrgUnits(): array
    {
        return $this->orgUnits;
    }
    public function setOrgUnits(array $orgUnits): void
    {
        $this->orgUnits = $orgUnits;
    }

    static public function fromArray(array $data): PersonDto
    {
        $dto = new self();
        $dto->setObjectId($data['id']);
        $dto->setName($data['name']);
        $dto->setDetails($data);
        $dto->setSearchIndex($data);

        $doctoralPrograms = [];
        foreach ($data['doctoralPrograms'] ?? [] as $doctoralProgram) {
            $doctoralPrograms[] = DoctoralProgramDto::fromArray($doctoralProgram);
        }
        $dto->setDoctoralPrograms($doctoralPrograms);

        $habilitations = [];
        foreach ($data['habilitations'] ?? [] as $habilitation) {
            $habilitations[] = HabilitationDto::fromArray($habilitation);
        }
        $dto->setHabilitations($habilitations);

        $orgUnits = [];
        foreach ($data['orgUnits'] ?? [] as $orgUnit) {
            $orgUnits[] = OrgUnitDto::fromArray($orgUnit);
        }
        $dto->setOrgUnits($orgUnits);

        $patents = [];
        foreach ($data['patents'] ?? [] as $patent) {
            $patents[] = PatentDto::fromArray($patent);
        }
        $dto->setPatents($patents);

        $projects = [];
        foreach ($data['projects'] ?? [] as $project) {
            $projects[] = ProjectDto::fromArray($project);
        }
        $dto->setProjects($projects);

        $publications = [];
        foreach ($data['publications'] ?? [] as $publication) {
            $publications[] = PublicationDto::fromArray($publication);
        }
        $dto->setPublications($publications);

        return $dto;
    }
}
