<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\OrgUnit;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\LanguageDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\StatusDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\VisibilityDto;
use Wtl\HioTypo3Connector\Trait\WithEndDate;
use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithLanguage;
use Wtl\HioTypo3Connector\Trait\WithStartDate;
use Wtl\HioTypo3Connector\Trait\WithStatus;
use Wtl\HioTypo3Connector\Trait\WithTitle;
use Wtl\HioTypo3Connector\Trait\WithVisibility;

class ProjectDto
{
    use WithEndDate;
    use WithId;
    use WithLanguage;
    use WithStartDate;
    use WithStatus;
    use WithTitle;
    use WithVisibility;

    protected string $objective = '';

    public function getObjective(): string
    {
        return $this->objective;
    }

    public function setObjective(string $objective): void
    {
        $this->objective = $objective;
    }

    static public function fromArray(array $data): self
    {
        $dto = new self();
        $dto->setEndDate(isset($data['endDate']) ? new \DateTime($data['endDate']) : null);
        $dto->setId($data['id']);
        $dto->setLanguage(LanguageDto::fromArray($data['language']) ?? null);
        $dto->setObjective($data['objective'] ?? '');
        $dto->setStartDate(isset($data['startDate']) ? new \DateTime($data['startDate']) : null);
        $dto->setStatus(StatusDto::fromArray($data['status']) ?? null);
        $dto->setTitle($data['title']);
        $dto->setVisibility(VisibilityDto::fromArray($data['visibility']) ?? null);
        return $dto;
    }
}
