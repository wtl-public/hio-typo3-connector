<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO\Publication;

class OrganizationDTO
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
        $organizationData = new self();
        $organizationData->setId($data['id']);
        $organizationData->setName($data['name'] ?? '');

        return $organizationData;
    }
}
