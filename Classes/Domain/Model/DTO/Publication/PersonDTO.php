<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO\Publication;

class PersonDTO
{
    protected ?int $id = null;
    protected string $name = '';
    protected ?OrganizationDTO $organization = null;
    protected ?ResearchPartnerDTO $researchPartner = null;

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

    public function getResearchPartner(): ResearchPartnerDTO|null
    {
        return $this->researchPartner;
    }
    public function setResearchPartner(?ResearchPartnerDTO $researchPartner): void
    {
        $this->researchPartner = $researchPartner;
    }

    static public function fromArray(array $data): self
    {
        $creatorData = new self();
        $creatorData->setId($data['id']);
        $creatorData->setName($data['name'] ?? '');
        if (is_array($data['organization'])) {
            $creatorData->setOrganization(OrganizationDTO::fromArray($data['organization']));
        }
        if (is_array($data['researchPartner'])) {
            $creatorData->setResearchPartner(ResearchPartnerDTO::fromArray($data['researchPartner']));
        }
        return $creatorData;
    }
}
