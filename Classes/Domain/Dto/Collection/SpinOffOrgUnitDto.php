<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Collection;

class SpinOffOrgUnitDto
{
    protected int $id;
    protected string $name = '';

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
        if (count($data) === 0) {
            return new self();
        }
        $orgUnitDto = new self();
        $orgUnitDto->setId($data['id']);
        $orgUnitDto->setName($data['name'] ?? '');

        return $orgUnitDto;
    }
}
