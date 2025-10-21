<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\Misc;

class StatusDto
{
    protected int $id;
    protected string $name;
    protected string $uniqueName;

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUniqueName(): string
    {
        return $this->uniqueName;
    }
    public function setUniqueName(string $uniqueName): void
    {
        $this->uniqueName = $uniqueName;
    }

    static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->setId($data['id']);
        $instance->setName($data['name'] ?? '');
        $instance->setUniqueName($data['uniqueName'] ?? '');
        return $instance;
    }
}
