<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Wtl\HioTypo3Connector\Domain\Dto\Collection\DoctorateDto;
use Wtl\HioTypo3Connector\Domain\Dto\Collection\HabilitationDto;
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

    protected array $doctorates = [];
    protected array $habilitations = [];
    protected array $patents = [];
    protected array $projects = [];
    protected array $publications = [];

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

    public function getDoctorates(): array
    {
        return $this->doctorates;
    }
    public function setDoctorates(array $doctorates): void
    {
        $this->doctorates = $doctorates;
    }

    public function getHabilitations(): array
    {
        return $this->habilitations;
    }
    public function setHabilitations(array $habilitations): void
    {
        $this->habilitations = $habilitations;
    }

    static public function fromArray(array $data): PersonDto
    {
        $releaseYear = $publication['journal']['releaseYear'] ?? null;
        $dto = new self();
        $dto->setObjectId($data['id']);
        $dto->setName($data['name']);
        $dto->setDetails($data);
        $dto->setSearchIndex($data);

        $publications = [];
        foreach ($data['publications'] ?? [] as $publication) {
            $publications[] = PublicationDto::fromArray($publication);
        }
        $dto->setPublications($publications);

        $projects = [];
        foreach ($data['projects'] ?? [] as $project) {
            $projects[] = ProjectDto::fromArray($project);
        }
        $dto->setProjects($projects);

        $patents = [];
        foreach ($data['patents'] ?? [] as $patent) {
            $patents[] = PatentDto::fromArray($patent);
        }
        $dto->setPatents($patents);

        $doctorates = [];
        foreach ($data['doctorates'] ?? [] as $doctorate) {
            $doctorates[] = DoctorateDto::fromArray($doctorate);
        }
        $dto->setDoctorates($doctorates);

        $habilitations = [];
        foreach ($data['habilitations'] ?? [] as $habilitation) {
            $habilitations[] = HabilitationDto::fromArray($habilitation);
        }
        $dto->setHabilitations($habilitations);

        return $dto;
    }
}
