<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Publication;

use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithType;

class GlobalIdentifierDto
{
    protected string $id;
    protected ?GlobalIdentifierTypeDto $globalIdentifierType;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getType(): ?GlobalIdentifierTypeDto
    {
        return $this->globalIdentifierType;
    }

    public function setType(?GlobalIdentifierTypeDto $globalIdentifierType): void
    {
        $this->globalIdentifierType = $globalIdentifierType;
    }

    static public function fromArray(array $data): self
    {
        $globalIdentifierData = new self();
        $globalIdentifierData->setId($data['id']);
        $globalIdentifierData->setType(isset($data['type']) ? GlobalIdentifierTypeDto::fromArray($data['type']) : null);

        return $globalIdentifierData;
    }
}
