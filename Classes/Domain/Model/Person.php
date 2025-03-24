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
     * @var ObjectStorage<Patent>
     */
    protected ObjectStorage $patents;

    /**
     * @var ObjectStorage<Doctorate>
     */
    protected ObjectStorage $doctorates;

    /**
     * @var ObjectStorage<Habilitation>
     */
    protected ObjectStorage $habilitations;

    /**
     * @var string
     */
    protected mixed $details;

     /**
     * @var string
     */
    protected mixed $searchIndex;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->publications = new ObjectStorage();
        $this->projects = new ObjectStorage();
        $this->patents = new ObjectStorage();
        $this->doctorates = new ObjectStorage();
        $this->habilitations = new ObjectStorage();
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

    public function getPatents(): ObjectStorage
    {
        return $this->patents;
    }
    public function setPatents(ObjectStorage $patents): void
    {
        $this->patents = $patents;
    }
    public function addPatent(Patent $patent): self
    {
        if (!$this->patents->contains($patent)) {
            $this->patents->attach($patent);
        }
        return $this;
    }
    public function removePatent(Patent $patent): self
    {
        if ($this->patents->contains($patent)) {
            $this->patents->detach($patent);
        }
        return $this;
    }

    public function getDoctorates(): ObjectStorage
    {
        return $this->doctorates;
    }
    public function setDoctorates(ObjectStorage $doctorates): void
    {
        $this->doctorates = $doctorates;
    }
    public function addDoctorate(Doctorate $doctorate): self
    {
        if (!$this->doctorates->contains($doctorate)) {
            $this->doctorates->attach($doctorate);
        }
        return $this;
    }
    public function removeDoctorate(Doctorate $doctorate): self
    {
        if ($this->doctorates->contains($doctorate)) {
            $this->doctorates->detach($doctorate);
        }
        return $this;
    }


    public function getHabilitations(): ObjectStorage
    {
        return $this->habilitations;
    }
    public function setHabilitations(ObjectStorage $habilitations): void
    {
        $this->habilitations = $habilitations;
    }
    public function addHabilitation(Habilitation $habilitation): self
    {
        if (!$this->habilitations->contains($habilitation)) {
            $this->habilitations->attach($habilitation);
        }
        return $this;
    }
    public function removeHabilitation(Habilitation $habilitation): self
    {
        if ($this->habilitations->contains($habilitation)) {
            $this->habilitations->detach($habilitation);
        }
        return $this;
    }

    /**
     * Get the value of searchIndex
     *
     * @return  string
     */ 
    public function getSearchIndex()
    {
        return $this->searchIndex;
    }

    /**
     * Set the value of searchIndex
     *
     * @param  string  $searchIndex
     *
     * @return  self
     */ 
    public function setSearchIndex(string $searchIndex)
    {
        $this->searchIndex = $searchIndex;

        return $this;
    }
}
