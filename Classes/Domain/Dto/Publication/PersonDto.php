<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Publication;

class PersonDto
{
    protected ?int $id = null;
    protected string $name = '';
    protected ?OrganizationDto $organization = null;
    protected ?ResearchPartnerDto $researchPartner = null;

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

    public function getResearchPartner(): ResearchPartnerDto|null
    {
        return $this->researchPartner;
    }
    public function setResearchPartner(?ResearchPartnerDto $researchPartner): void
    {
        $this->researchPartner = $researchPartner;
    }

    static public function fromArray(array $data): self
    {
        $creatorData = new self();
        $creatorData->setId($data['id']);
        $creatorData->setName($data['name'] ?? '');
        if (is_array($data['organization'])) {
            $creatorData->setOrganization(OrganizationDto::fromArray($data['organization']));
        }
        if (is_array($data['researchPartner'])) {
            $creatorData->setResearchPartner(ResearchPartnerDto::fromArray($data['researchPartner']));
        }
        return $creatorData;
    }
}
