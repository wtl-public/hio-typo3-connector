<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\Person;

class AttributeDto
{
    protected string $name = '';
    protected ?string $value = '';

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
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
        $dto->setName($data['name']);
        $dto->setValue($data['value'] ?? null);

        return $dto;
    }
}
