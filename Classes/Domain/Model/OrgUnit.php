<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class OrgUnit extends AbstractEntity
{
    protected int $objectId;

    protected string $title = '';

    /**
     * @var string
     */
    protected mixed $details;

    /**
     * @var string
     */
    protected mixed $searchIndex;

    /**
     * @var ObjectStorage<DoctoralProgram>
     */
    protected ObjectStorage $doctoralPrograms;

    /**
     * @var ObjectStorage<Habilitation>
     */
    protected ObjectStorage $habilitations;

    /**
     * @var ObjectStorage<Patent>
     */
    protected ObjectStorage $patents;

    /**
     * @var ObjectStorage<Person>
     */
    protected ObjectStorage $persons;

    /**
     * @var ObjectStorage<Project>
     */
    protected ObjectStorage $projects;

    /**
     * @var ObjectStorage<Publication>
     */
    protected ObjectStorage $publications;

    /**
     * @var ObjectStorage<ResearchInfrastructure>
     */
    protected ObjectStorage $researchInfrastructures;

    /**
     * @var ObjectStorage<SpinOff>
     */
    protected ObjectStorage $spinOffs;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->doctoralPrograms = new ObjectStorage();
        $this->habilitations = new ObjectStorage();
        $this->patents = new ObjectStorage();
        $this->persons = new ObjectStorage();
        $this->projects = new ObjectStorage();
        $this->publications = new ObjectStorage();
        $this->researchInfrastructures = new ObjectStorage();
        $this->spinOffs = new ObjectStorage();
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
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getDetails(): mixed
    {
        return json_decode($this->details, true);
    }
    public function setDetails($details): void
    {
        $this->details = json_encode($details);
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

    public function getPersons(): ObjectStorage
    {
        return $this->persons;
    }
    public function setPersons(ObjectStorage $persons): void
    {
        $this->persons = $persons;
    }
    public function addPerson(Person $person): self
    {
        if (!$this->persons->contains($person)) {
            $this->persons->attach($person);
        }
        return $this;
    }
    public function removePerson(Person $person): self
    {
        if ($this->persons->contains($person)) {
            $this->persons->detach($person);
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

    public function getDoctoralPrograms(): ObjectStorage
    {
        return $this->doctoralPrograms;
    }
    public function setDoctoralPrograms(ObjectStorage $doctoralPrograms): void
    {
        $this->doctoralPrograms = $doctoralPrograms;
    }
    public function addDoctoralProgram(DoctoralProgram $doctoralProgram): self
    {
        if (!$this->doctoralPrograms->contains($doctoralProgram)) {
            $this->doctoralPrograms->attach($doctoralProgram);
        }
        return $this;
    }
    public function removeDoctoralProgram(DoctoralProgram $doctoralProgram): self
    {
        if ($this->doctoralPrograms->contains($doctoralProgram)) {
            $this->doctoralPrograms->detach($doctoralProgram);
        }
        return $this;
    }

    public function getResearchInfrastructures(): ObjectStorage
    {
        return $this->researchInfrastructures;
    }
    public function setResearchInfrastructures(ObjectStorage $researchInfrastructures): void
    {
        $this->researchInfrastructures = $researchInfrastructures;
    }
    public function addResearchInfrastructure(ResearchInfrastructure $researchInfrastructure): self
    {
        if (!$this->researchInfrastructures->contains($researchInfrastructure)) {
            $this->researchInfrastructures->attach($researchInfrastructure);
        }
        return $this;
    }
    public function removeResearchInfrastructure(ResearchInfrastructure $researchInfrastructure): self
    {
        if ($this->researchInfrastructures->contains($researchInfrastructure)) {
            $this->researchInfrastructures->detach($researchInfrastructure);
        }
        return $this;
    }

    public function getSpinOffs(): ObjectStorage
    {
        return $this->spinOffs;
    }
    public function setSpinOffs(ObjectStorage $spinOffs): void
    {
        $this->spinOffs = $spinOffs;
    }
    public function addSpinOff(SpinOff $spinOff): self
    {
        if (!$this->spinOffs->contains($spinOff)) {
            $this->spinOffs->attach($spinOff);
        }
        return $this;
    }
    public function removeSpinOff(SpinOff $spinOff): self
    {
        if ($this->spinOffs->contains($spinOff)) {
            $this->spinOffs->detach($spinOff);
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
}
