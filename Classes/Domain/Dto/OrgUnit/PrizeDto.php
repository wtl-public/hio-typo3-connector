<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\OrgUnit;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\StatusDto;
use Wtl\HioTypo3Connector\Domain\Dto\Nomination\OrgUnitDto;
use Wtl\HioTypo3Connector\Trait\WithDescription;
use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithStatus;
use Wtl\HioTypo3Connector\Trait\WithTitle;
use Wtl\HioTypo3Connector\Trait\WithType;

class PrizeDto
{
    use WithDescription;
    use WithId;
    use WithStatus;
    use WithTitle;
    use WithType;

    protected ?array $orgUnits = null;
    protected ?string $category;
    protected ?string $endowed;

    public function getOrgUnits(): ?array
    {
        return $this->orgUnits;
    }
    public function setOrgUnits(?array $orgUnits): void
    {
        $this->orgUnits = $orgUnits;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }
    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }
    public function getEndowed(): ?string
    {
        return $this->endowed;
    }
    public function setEndowed(?string $endowed): void
    {
        $this->endowed = $endowed;
    }

    static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->setCategory($data['category'] ?? null);
        $instance->setDescription($data['description'] ?? null);
        $instance->setEndowed($data['endowed'] ?? null);
        $instance->setId($data['id'] ?? null);
        $instance->setOrgUnits(array_map(fn($item) => OrgUnitDto::fromArray($item), $data['orgUnits'] ?? []));
        $instance->setStatus(StatusDto::fromArray($data['status']) ?? null);
        $instance->setTitle($data['title'] ?? null);
        $instance->setType($data['type'] ?? null);
        return $instance;
    }
}
