<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\Person\Account;

use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithName;
use Wtl\HioTypo3Connector\Trait\WithUniqueName;

class BlockedDto
{
    use WithId;
    use WithName;
    use WithUniqueName;

    static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->setId($data['id']);
        $instance->setName($data['name'] ?? '');
        $instance->setUniqueName($data['uniqueName'] ?? '');
        return $instance;
    }
}
