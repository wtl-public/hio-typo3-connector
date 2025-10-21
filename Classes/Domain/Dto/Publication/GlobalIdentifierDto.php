<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Publication;

use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithType;

class GlobalIdentifierDto
{
    use WithId;
    use WithType;

    static public function fromArray(array $data): self
    {
        $globalIdentifierData = new self();
        $globalIdentifierData->setId($data['id']);
        $globalIdentifierData->setType($data['type']);

        return $globalIdentifierData;
    }
}
