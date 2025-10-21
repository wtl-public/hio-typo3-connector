<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Patent;

use Wtl\HioTypo3Connector\Domain\Dto\Person\OrgUnitDto;
use Wtl\HioTypo3Connector\Domain\Dto\Person\ResearchPartnerDto;
use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithName;
use Wtl\HioTypo3Connector\Trait\WithRole;

class PersonDto
{
    use WithId;
    use WithName;
    use WithRole;

    protected ?OrgUnitDto $orgUnit = null;
    protected ?ResearchPartnerDto $researchPartner = null;

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
