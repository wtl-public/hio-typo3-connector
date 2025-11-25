<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\OrgUnit;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\LanguageDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\VisibilityDto;
use Wtl\HioTypo3Connector\Trait\WithDescription;
use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithLanguage;
use Wtl\HioTypo3Connector\Trait\WithTitle;
use Wtl\HioTypo3Connector\Trait\WithType;
use Wtl\HioTypo3Connector\Trait\WithVisibility;

class ResearchInfrastructureDto
{
    use WithDescription;
    use WithId;
    use WithLanguage;
    use WithTitle;
    use WithType;
    use WithVisibility;

    static public function fromArray(array $data): self
    {
        if (count($data) === 0) {
            return new self();
        }
        $dto = new self();
        $dto->setDescription($data['description'] ?? '');
        $dto->setId($data['id']);
        $dto->setLanguage(LanguageDto::fromArray($data['language']) ?? null);
        $dto->setTitle($data['name'] ?? '');
        $dto->setType($data['type'] ?? '');
        $dto->setVisibility(VisibilityDto::fromArray($data['visibility']) ?? null);

        return $dto;
    }
}
