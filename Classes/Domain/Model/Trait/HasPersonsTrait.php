<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\Trait;

use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Wtl\HioTypo3Connector\Domain\Model\Person;

trait HasPersonsTrait
{
    /**
     * @var ObjectStorage<Person>
     */
    #[Lazy]
    protected ObjectStorage $persons;

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
}

