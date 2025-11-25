<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructure\Publication;

use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithName;
use Wtl\HioTypo3Connector\Trait\WithUniqueName;

class  PeerReviewedDto
{
    use WithId;
    use WithName;
    use WithUniqueName;

    static public function fromArray(array $data): PeerReviewedDto
    {
        $dto = new self();
        $dto->setId($data['id']);
        $dto->setName($data['name'] ?? '');
        $dto->setUniqueName($data['uniquename'] ?? '');

        return  $dto;
    }
}
