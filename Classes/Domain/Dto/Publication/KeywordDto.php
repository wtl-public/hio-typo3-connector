<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\Publication;

class KeywordDto
{
    protected int $id;
    protected string $name;

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

    static public function fromArray(array $data): self
    {
        $instance = new self();
        $instance->setId($data['id']);
        $instance->setName($data['name'] ?? '');
        return $instance;
    }
}
