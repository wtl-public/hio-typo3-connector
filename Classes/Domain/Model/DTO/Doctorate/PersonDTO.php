<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO\Doctorate;

class PersonDTO
{
    protected ?int $id = null;
    protected string $name = '';
    protected ?OrganizationDTO $organization = null;

    public function getId(): int|null
    {
        return $this->id;
    }
    public function setId(?int $id): void
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

    public function getOrganization(): OrganizationDTO|null
    {
        return $this->organization;
    }
    public function setOrganization(?OrganizationDTO $organization): void
    {
        $this->organization = $organization;
    }

    static public function fromArray(array $data): self
    {
        $personData = new self();
        $personData->setId($data['id']);
        $personData->setName($data['name'] ?? '');
        if (is_array($data['organization'])) {
            $personData->setOrganization(OrganizationDTO::fromArray($data['organization']));
        }
        return $personData;
    }
}
