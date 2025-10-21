<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\Person;

use Wtl\HioTypo3Connector\Trait\WithValidFrom;
use Wtl\HioTypo3Connector\Trait\WithValidTo;

class AttributeDto
{
    use WithValidFrom;
    use WithValidTo;

    protected ?array $type = null;
    protected ?string $value = '';

    public function getType(): array|null
    {
        return $this->type;
    }
    public function setType(?array $type): void
    {
        $this->type = $type;
    }

    public function getValue(): string|null
    {
        return $this->value;
    }
    public function setValue(string|null $value): void
    {
        $this->value = $value;
    }

    static public function fromArray(array $data): self
    {
        $dto = new self();
        $dto->setType($data['type'] ?? null);
        $dto->setValue($data['value'] ?? null);
        if (isset($data['validFrom'])) {
            $dto->setValidFrom(new \DateTime($data['validFrom']));
        }
        if (isset($data['validTo'])) {
            $dto->setValidTo(new \DateTime($data['validTo']));
        }

        return $dto;
    }
}
