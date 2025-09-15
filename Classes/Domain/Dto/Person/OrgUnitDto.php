<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Person;

class OrgUnitDto
{
    protected string $affiliation = '';
    protected int $id;
    protected string $name = '';
    protected ?\DateTime $validFrom = null;
    protected ?\DateTime $validTo = null;
    protected string $visibility = '';

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

    public function getAffiliation(): string
    {
        return $this->affiliation;
    }
    public function setAffiliation(string $affiliation): void
    {
        $this->affiliation = $affiliation;
    }

    public function getValidFrom(): ?\DateTime
    {
        return $this->validFrom;
    }
    public function setValidFrom(?\DateTime $validFrom): void
    {
        $this->validFrom = $validFrom;
    }

    public function getValidTo(): ?\DateTime
    {
        return $this->validTo;
    }
    public function setValidTo(?\DateTime $validTo): void
    {
        $this->validTo = $validTo;
    }

    public function getVisibility(): string
    {
        return $this->visibility;
    }
    public function setVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
    }

    static public function fromArray(array $data): self
    {
        if (count($data) === 0) {
            return new self();
        }
        $dto = new self();
        $dto->setId($data['id']);
        $dto->setName($data['name'] ?? '');
        $dto->setAffiliation($data['affiliation'] ?? '');
        $dto->setValidFrom(isset($data['validFrom']) ? new \DateTime($data['validFrom']) : null);
        $dto->setValidTo(isset($data['validTo']) ? new \DateTime($data['validTo']) : null);
        $dto->setVisibility($data['visibility'] ?? '');

        return $dto;
    }
}
