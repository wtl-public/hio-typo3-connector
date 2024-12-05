<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO\Project;

use Wtl\HioTypo3Connector\Domain\Model\DTO\Publication\OrganizationDTO;
use Wtl\HioTypo3Connector\Domain\Model\DTO\Publication\ResearchPartnerDTO;

class PersonDTO
{
    protected ?int $id = null;
    protected string $person = '';
    protected ?OrganizationDTO $organization = null;
    protected string $role = '';
    protected \DateTime $startDate;
    protected \DateTime $endDate;

    public function getId(): int|null
    {
        return $this->id;
    }
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getPerson(): string
    {
        return $this->person;
    }
    public function setPerson(string $person): void
    {
        $this->person = $person;
    }

    public function getOrganization(): OrganizationDTO|null
    {
        return $this->organization;
    }
    public function setOrganization(?OrganizationDTO $organization): void
    {
        $this->organization = $organization;
    }

    public function getRole(): string
    {
        return $this->role;
    }
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }
    public function setStartDate(\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }
    public function setEndDate(\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    static public function fromArray(array $data): self
    {
        $startDate = null;
        if (isset($data['startDate'])) {
            $startDate = \DateTime::createFromFormat(format: 'Y-m-d', datetime: $data['startDate']);
        }
        $endDate = null;
        if (isset($data['endDate'])) {
            $endDate = \DateTime::createFromFormat('Y-m-d', $data['endDate']);
        }

        $dto = new self();
        $dto->setId($data['id']);
        $dto->setPerson($data['person'] ?? '');
        if (isset($data['organization'])) {
            $dto->setOrganization(OrganizationDTO::fromArray($data['organization']));
        }
        $dto->setRole($data['role'] ?? '');
        $dto->setStartDate($startDate);
        $dto->setEndDate($endDate);

        return $dto;
    }
}
