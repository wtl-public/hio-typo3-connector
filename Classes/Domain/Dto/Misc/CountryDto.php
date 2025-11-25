<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Misc;

use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithName;
use Wtl\HioTypo3Connector\Trait\WithUniqueName;

class  CountryDto
{
    use WithId;
    use WithName;
    use WithUniqueName;

    static public function fromArray(array $data): CountryDto
    {
        $dto = new self();
        $dto->setId($data['id']);
        $dto->setName($data['name'] ?? '');
        $dto->setUniqueName($data['uniquename'] ?? '');

        return  $dto;
    }
}
