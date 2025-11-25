<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Person;

use Wtl\HioTypo3Connector\Domain\Dto\Person\Account\BlockedDto;
use Wtl\HioTypo3Connector\Domain\Dto\Person\Account\PurposeDto;
use Wtl\HioTypo3Connector\Trait\WithValidFrom;
use Wtl\HioTypo3Connector\Trait\WithValidTo;

class AccountDto
{
    use WithValidFrom;
    use WithValidTo;

    protected ?BlockedDto $blocked;
    protected ?string $externalSystem;
    protected ?PurposeDto $purpose;
    protected ?string $sourceFilter;
    protected ?string $username;

    public function getBlocked(): ?BlockedDto
    {
        return $this->blocked;
    }

    public function setBlocked(?BlockedDto $blocked): void
    {
        $this->blocked = $blocked;
    }

    public function getExternalSystem(): ?string
    {
        return $this->externalSystem;
    }

    public function setExternalSystem(?string $externalSystem): void
    {
        $this->externalSystem = $externalSystem;
    }

    public function getPurpose(): ?PurposeDto
    {
        return $this->purpose;
    }

    public function setPurpose(?PurposeDto $purpose): void
    {
        $this->purpose = $purpose;
    }

    public function getSourceFilter(): ?string
    {
        return $this->sourceFilter;
    }

    public function setSourceFilter(?string $sourceFilter): void
    {
        $this->sourceFilter = $sourceFilter;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    static public function fromArray(array $data): self
    {
        $dto = new self();

        $dto->setBlocked(isset($data['blocked']) ? BlockedDto::fromArray($data['blocked']) : null);
        $dto->setExternalSystem($data['externalsystem'] ?? null);
        $dto->setPurpose(isset($data['purpose']) ? PurposeDto::fromArray($data['purpose']) : null);
        $dto->setSourceFilter($data['sourcefilter'] ?? null);
        $dto->setUsername($data['username'] ?? null);
        $dto->setValidFrom(isset($data['validfrom']) ? new \DateTimeImmutable($data['validfrom']) : null);
        $dto->setValidTo(isset($data['validto']) ? new \DateTimeImmutable($data['validto']) : null);

        return $dto;
    }
}
