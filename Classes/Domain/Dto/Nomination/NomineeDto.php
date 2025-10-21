<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\Nomination;

use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithName;

class NomineeDto
{
    use WithId;
    use WithName;

    static public function fromArray(array $data): self
    {
        $instance = new self();
        $instance->setId($data['id'] ?? null);
        $instance->setName($data['name'] ?? '');
        return $instance;
    }
}

