<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Person;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\StatusDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\VisibilityDto;
use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithStatus;
use Wtl\HioTypo3Connector\Trait\WithTitle;
use Wtl\HioTypo3Connector\Trait\WithType;
use Wtl\HioTypo3Connector\Trait\WithVisibility;

class PublicationDto
{
    use WithId;
    use WithStatus;
    use WithTitle;
    use WithType;
    use WithVisibility;

    protected string $document = '';
    protected string $resource = '';
    protected ?bool $reviewed = null;
    protected string $subtitle = '';

    public function getDocument(): string
    {
        return $this->document;
    }

    public function setDocument(string $document): void
    {
        $this->document = $document;
    }

    public function getResource(): string
    {
        return $this->resource;
    }

    public function setResource(string $resource): void
    {
        $this->resource = $resource;
    }

    public function getReviewed(): ?bool
    {
        return $this->reviewed;
    }

    public function setReviewed(?bool $reviewed): void
    {
        $this->reviewed = $reviewed;
    }

    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    public static function fromArray(array $data): self
    {
        $dto = new self();
        $dto->setDocument($data['document'] ?? '');
        $dto->setId($data['id'] ?? null);
        $dto->setResource($data['resource'] ?? '');
        $dto->setReviewed($data['reviewed'] ?? null);
        $dto->setStatus(StatusDto::fromArray($data['status']) ?? null);
        $dto->setSubtitle($data['subtitle'] ?? '');
        $dto->setTitle($data['title'] ?? '');
        $dto->setType($data['type'] ?? '');
        $dto->setVisibility(VisibilityDto::fromArray($data['visibility']) ?? null);

        return $dto;
    }
}
