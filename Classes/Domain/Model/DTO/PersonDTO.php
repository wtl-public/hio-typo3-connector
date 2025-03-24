<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class PersonDTO
{
    protected int $objectId = 0;
    protected string $name = '';
    protected array $details = [];
    protected array $searchIndex = [];
    protected array $publications = [];
    protected array $projects = [];
    protected array $patents = [];
    protected array $doctorates = [];
    protected array $habilitations = [];

    public function getObjectId(): int
    {
        return $this->objectId;
    }
    public function setObjectId($objectId): void
    {
        $this->objectId = $objectId;
    }

    public function getDetails(): array
    {
        return $this->details;
    }
    public function setDetails(array $details): void
    {
        $this->details = $details;
    }

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

    public function getSearchIndex()
    {
        return $this->searchIndex;
    }

    public function setSearchIndex($searchIndex)
    {
        $this->searchIndex = $searchIndex;

        return $this;
    }
}
