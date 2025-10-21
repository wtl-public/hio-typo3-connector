<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Project;

use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithName;

class SubjectAreaDto
{
    use WithId;
    use WithName;

    public static function fromArray(array $data): self
    {
        $subjectArea = new self();
        $subjectArea->setId($data['id']);
        $subjectArea->setName($data['name']);
        return $subjectArea;
    }
}
