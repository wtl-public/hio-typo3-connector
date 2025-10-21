<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Nomination\Prize;

use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithName;

class AwardingOrganizationDto
{
    use WithId;
    use WithName;

    static public function fromArray(array $data): self
    {
        if (count($data) === 0) {
            return new self();
        }

        $dto = new self();
        $dto->setId($data['id']);
        $dto->setName($data['name'] ?? '');

        return $dto;
    }
}
