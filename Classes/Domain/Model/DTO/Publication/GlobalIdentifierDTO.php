<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO\Publication;

class GlobalIdentifierDTO
{
    protected string $id = '';
    protected string $type = '';

    public function getId(): string
    {
        return $this->id;
    }
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getType(): string
    {
        return $this->type;
    }
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    static public function fromArray(array $data): self
    {
        $globalIdentifierData = new self();
        $globalIdentifierData->setId($data['id']);
        $globalIdentifierData->setType($data['type']);

        return $globalIdentifierData;
    }
}
