<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\OrgUnit;

use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithName;

class PersonDto
{
    use WithId;
    use WithName;

    protected array $affiliations = [];

    public function getAffiliations(): array
    {
        return $this->affiliations;
    }
    public function setAffiliations(array $affiliations): void
    {
        $this->affiliations = $affiliations;
    }

    static public function fromArray(array $data): self
    {
        $personDto = new self();
        $personDto->setId($data['id']);
        $personDto->setName($data['name'] ?? '');
        $personDto->setAffiliations($data['affiliations'] ?? []);
        return $personDto;
    }
}
