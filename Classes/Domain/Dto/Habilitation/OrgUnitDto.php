<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Habilitation;

use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithName;

class OrgUnitDto
{
    use WithId;
    use WithName;

    static public function fromArray(array $data): self
    {
        if (count($data) === 0) {
            return new self();
        }
        $organizationDto = new self();
        $organizationDto->setId($data['id']);
        $organizationDto->setName($data['name'] ?? '');

        return $organizationDto;
    }
}
