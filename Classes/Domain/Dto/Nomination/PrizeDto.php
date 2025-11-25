<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\Nomination;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\EndowedDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\StatusDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\TypeDto;
use Wtl\HioTypo3Connector\Domain\Dto\Nomination\Prize\AwardingOrganizationDto;
use Wtl\HioTypo3Connector\Trait\WithDescription;
use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithStatus;
use Wtl\HioTypo3Connector\Trait\WithTitle;

class PrizeDto
{
    use WithDescription;
    use WithId;
    use WithStatus;
    use WithTitle;

    protected ?array $awardingOrganizations = null;
    protected ?string $category;
    protected ?EndowedDto $endowed;

    protected ?TypeDto $prizeType;

    public function getAwardingOrganizations(): ?array
    {
        return $this->awardingOrganizations;
    }
    public function setAwardingOrganizations(?array $awardingOrganizations): void
    {
        $this->awardingOrganizations = $awardingOrganizations;
    }
    public function getCategory(): ?string
    {
        return $this->category;
    }
    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }
    public function getEndowed(): ?EndowedDto
    {
        return $this->endowed;
    }
    public function setEndowed(?EndowedDto $endowed): void
    {
        $this->endowed = $endowed;
    }

    public function getPrizeType(): ?TypeDto
    {
        return $this->prizeType;
    }
    public function setPrizeType(?TypeDto $prizeType): void
    {
        $this->prizeType = $prizeType;
    }

    static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->setAwardingOrganizations(array_map(fn($item) => AwardingOrganizationDto::fromArray($item), $data['awardingOrganizations'] ?? []));
        $instance->setCategory($data['category'] ?? null);
        $instance->setDescription($data['description'] ?? null);
        $instance->setEndowed(EndowedDto::fromArray($data['endowed']) ?? null);
        $instance->setId($data['id'] ?? null);
        $instance->setStatus(StatusDto::fromArray($data['status']) ?? null);
        $instance->setTitle($data['title'] ?? null);
        $instance->setPrizeType(TypeDto::fromArray($data['prizeType']) ?? null);
        return $instance;
    }
}
