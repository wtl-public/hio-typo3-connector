<?php

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithName;
use Wtl\HioTypo3Connector\Trait\WithUniqueName;

class AbstractPropertyDto
{
    use WithId;
    use WithName;
    use WithUniquename;

    public static function fromArray(array $data): static
    {
        $instance = new static();
        $instance->setId($data['id']);
        $instance->setName($data['name'] ?? '');
        $instance->setUniqueName($data['uniqueName'] ?? '');

        return $instance;
    }
}
