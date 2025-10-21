<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Person;

use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithName;

class OrgUnitDto
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
        if (count($data) === 0) {
            return new self();
        }

        $dto = new self();
        $dto->setId($data['id']);
        $dto->setName($data['name'] ?? '');
        $dto->setAffiliations($data['affiliations'] ?? []);

        return $dto;
    }
}
