<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructure;

use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithName;
use Wtl\HioTypo3Connector\Trait\WithRole;

class OrgUnitDto
{
    use WithId;
    use WithName;

    static public function fromArray(array $data): self
    {
        if (count($data) === 0) {
            return new self();
        }
        $orgUnitDto = new self();
        $orgUnitDto->setId($data['id']);
        $orgUnitDto->setName($data['name'] ?? '');

        return $orgUnitDto;
    }
}
