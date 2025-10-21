<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\OrgUnit;

use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithName;

class SpinOffDto
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
