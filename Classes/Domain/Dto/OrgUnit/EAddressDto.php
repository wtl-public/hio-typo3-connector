<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\OrgUnit;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\AddressTagDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\EAddressTypeDto;
use Wtl\HioTypo3Connector\Trait\WithValidFrom;
use Wtl\HioTypo3Connector\Trait\WithValidTo;

class EAddressDto
{
    use WithValidFrom;
    use WithValidTo;

    protected ?AddressTagDto $addressTag = null;
    protected ?EAddressTypeDto $eAddressType = null;
    protected ?string $value = null;

    public function getAddressTag(): ?AddressTagDto
    {
        return $this->addressTag;
    }
    public function setAddressTag(?AddressTagDto $addressTag): void
    {
        $this->addressTag = $addressTag;
    }

    public function getEAddressType(): ?EAddressTypeDto
    {
        return $this->eAddressType;
    }
    public function setEAddressType(?EAddressTypeDto $eAddressType): void
    {
        $this->eAddressType = $eAddressType;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    static public function fromArray(array $data): EAddressDto
    {
        $dto = new self();
        $dto->setAddressTag(AddressTagDto::fromArray($data['addressTag'] ?? null));
        $dto->setEAddressType(EAddressTypeDto::fromArray($data['eAddressType'] ?? null));
        $dto->setValidFrom(new \DateTime($data['validFrom']) ?? null);
        $dto->setValidTo(new \DateTime($data['validTo']) ?? null);
        $dto->setValue($data['value'] ?? null);
        return $dto;
    }
}
