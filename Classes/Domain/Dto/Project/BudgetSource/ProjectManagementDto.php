<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\Project\BudgetSource;

use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithName;
use Wtl\HioTypo3Connector\Trait\WithUniqueName;

class ProjectManagementDto
{
    use WithId;
    use WithName;

    static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->setId($data['id']);
        $instance->setName($data['name'] ?? '');
        return $instance;
    }
}
