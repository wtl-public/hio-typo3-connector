<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Collection;

class PersonDto
{
    protected ?int $id = null;
    protected string $name = '';
    protected ?OrganizationDto $organization = null;
    protected ?ResearchPartnerDto $researchPartner = null;
    protected ?string $role = null;

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

    public function getOrganization(): OrganizationDto|null
    {
        return $this->organization;
    }
    public function setOrganization(?OrganizationDto $organization): void
    {
        $this->organization = $organization;
    }

    public function getResearchPartner(): ?ResearchPartnerDto
    {
        return $this->researchPartner;
    }

    public function setResearchPartner(?ResearchPartnerDto $researchPartner): void
    {
        $this->researchPartner = $researchPartner;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): void
    {
        $this->role = $role;
    }

    static public function fromArray(array $data): self
    {
        $personDto = new self();
        $personDto->setId($data['id']);
        $personDto->setName($data['name'] ?? '');
        if (isset($data['role'])) {
            $personDto->setRole($data['role']);
        }
        if (isset($data['organization']) && is_array($data['organization'])) {
            $personDto->setOrganization(OrganizationDto::fromArray($data['organization']));
        }
        if (isset($data['researchPartner']) && is_array($data['researchPartner'])) {
            $personDto->setResearchPartner(ResearchPartnerDto::fromArray($data['researchPartner']));
        }
        return $personDto;
    }
}
