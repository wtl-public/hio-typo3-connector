<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Nomination extends AbstractEntity
{
    public const ORDERABLE_COLUMNS = ['title', 'type', 'nominationYear', 'status'];

    protected ?int $nominationYear = null;
    protected int $objectId = 0;

    protected ?string $scope = null;
    protected ?string $status = null;
    protected string $title = '';
    protected ?string $type = '';
    protected ?string $visibility = '';

    /**
     * @var string
     */
    protected mixed $details;

     /**
     * @var string
     */
    protected mixed $searchIndex;

    /**
     * @var ObjectStorage<Person>
     */
    protected ObjectStorage $nominees;

    /**
     * @var ObjectStorage<OrgUnit>
     */
    protected ObjectStorage $orgUnits;

    /**
     * @var ObjectStorage<Project>
     */
    protected ObjectStorage $projects;

    /**
     * @var ObjectStorage<Publication>
     */
    protected ObjectStorage $publications;


    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->nominees = new ObjectStorage();
        $this->orgUnits = new ObjectStorage();
        $this->projects = new ObjectStorage();
        $this->publications = new ObjectStorage();
    }

    public function getNominationYear(): ?int
    {
        return $this->nominationYear;
    }
    public function setNominationYear(?int $nominationYear): void
    {
        $this->nominationYear = $nominationYear;
    }

    public function getObjectId(): int
    {
        return $this->objectId;
    }
    public function setObjectId($objectId): void
    {
        $this->objectId = $objectId;
    }

    public function getScope(): ?string
    {
        return $this->scope;
    }
    public function setScope(?string $scope): void
    {
        $this->scope = $scope;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getNominees(): ObjectStorage
    {
        return $this->nominees;
    }
    public function setNominees(ObjectStorage $nominees): void
    {
        $this->nominees = $nominees;
    }
    public function addNominee(Person $nominee): self
    {
        if (!$this->nominees->contains($nominee)) {
            $this->nominees->attach($nominee);
        }
        return $this;
    }
    public function removeNominee(Person $nominee): self
    {
        if ($this->nominees->contains($nominee)) {
            $this->nominees->detach($nominee);
        }
        return $this;
    }

    public function getOrgUnits(): ObjectStorage
    {
        return $this->orgUnits;
    }
    public function setOrgunits(ObjectStorage $orgUnits): void
    {
        $this->orgUnits = $orgUnits;
    }
    public function addOrgUnit(OrgUnit $orgUnit): self
    {
        if (!$this->orgUnits->contains($orgUnit)) {
            $this->orgUnits->attach($orgUnit);
        }
        return $this;
    }
    public function removeOrgUnit(OrgUnit $orgUnit): self
    {
        if ($this->orgUnits->contains($orgUnit)) {
            $this->orgUnits->detach($orgUnit);
        }
        return $this;
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

    public function getDetails(): mixed
    {
        return json_decode($this->details, true);
    }
    public function setDetails($details): void
    {
        $this->details = json_encode($details);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType($type): void
    {
        $this->type = $type;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getVisibility(): ?string
    {
        return $this->visibility;
    }
    public function setVisibility(?string $visibility): void
    {
        $this->visibility = $visibility;
    }
}
