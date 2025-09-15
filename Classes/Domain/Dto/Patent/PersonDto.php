<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Patent;

use Wtl\HioTypo3Connector\Domain\Dto\Person\OrgUnitDto;
use Wtl\HioTypo3Connector\Domain\Dto\Person\ResearchPartnerDto;

class PersonDto
{
    protected ?int $id = null;
    protected string $name = '';
    protected ?OrgUnitDto $orgUnit = null;
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

    public function getOrgUnit(): OrgUnitDto|null
    {
        return $this->orgUnit;
    }
    public function setOrgUnit(?OrgUnitDto $orgUnit): void
    {
        $this->orgUnit = $orgUnit;
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
            $personDto->setOrgUnit(OrgUnitDto::fromArray($data['organization']));
        }
        if (isset($data['researchPartner']) && is_array($data['researchPartner'])) {
            $personDto->setResearchPartner(ResearchPartnerDto::fromArray($data['researchPartner']));
        }
        return $personDto;
    }
}
