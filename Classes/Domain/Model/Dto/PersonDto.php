<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\Dto;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class PersonDto
{
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;

    protected string $name = '';
    protected array $publications = [];
    protected array $projects = [];
    protected array $patents = [];
    protected array $doctorates = [];
    protected array $habilitations = [];

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
        return $dto;
    }
}
