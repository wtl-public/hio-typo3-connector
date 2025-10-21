<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Project;

use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithName;

class ResearchAreaDto
{
    use WithId;
    use WithName;

    public static function fromArray(array $data): self
    {
        $researchArea = new self();
        $researchArea->setId($data['id']);
        $researchArea->setName($data['name']);
        return $researchArea;
    }
}
