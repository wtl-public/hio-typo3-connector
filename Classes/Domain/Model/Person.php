<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Person extends AbstractEntity
{
    protected int $objectId;

    protected string $name = '';

    /**
     * @var ObjectStorage<Publication>
     */
    protected ObjectStorage $publications;

    /**
     * @var ObjectStorage<Project>
     */
    protected ObjectStorage $projects;

    /**
     * @var string
     */
    protected mixed $details;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->publications = new ObjectStorage();
        $this->projects = new ObjectStorage();
    }

    public function getObjectId(): int
    {
        return $this->objectId;
    }
    public function setObjectId($objectId): void
    {
        $this->objectId = $objectId;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDetails(): mixed
    {
        return $this->details;
    }
    public function setDetails($details): void
    {
        $this->details = $details;
    }

    public function getPublications(): ObjectStorage
    {
        return $this->publications;
    }
    public function setPublications(ObjectStorage $publications): void
    {
        $this->publications = $publications;
    }
    public function addPublication(Publication $publication): self
    {
        if (!$this->publications->contains($publication)) {
            $this->publications->attach($publication);
        }
        return $this;
    }
    public function removePublication(Publication $publication): self
    {
        if ($this->publications->contains($publication)) {
            $this->publications->detach($publication);
        }
        return $this;
    }

    public function getProjects(): ObjectStorage
    {
        return $this->projects;
    }
    public function setProjects(ObjectStorage $projects): void
    {
        $this->projects = $projects;
    }
    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects->attach($project);
        }
        return $this;
    }
    public function removeProject(Project $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->detach($project);
        }
        return $this;
    }
}
