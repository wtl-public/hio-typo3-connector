<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\OrgUnit;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\AddressTagDto;

class PostAddressDto
{
    protected ?string $addressAddition = null;
    protected ?AddressTagDto $addressTag = null;
    protected ?string $city = null;
    protected ?string $company = null;
    protected ?string $country = null;
    protected ?string $postOfficeBox = null;
    protected ?string $postcode = null;
    protected ?string $state = null;
    protected ?string $street = null;
    protected ?\DateTime $validFrom = null;
    protected ?\DateTime $validTo = null;

    public function getAddressAddition(): ?string
    {
        return $this->addressAddition;
    }

    public function setAddressAddition(?string $addressAddition): void
    {
        $this->addressAddition = $addressAddition;
    }

    public function getAddressTag(): ?AddressTagDto
    {
        return $this->addressTag;
    }

    public function setAddressTag(?AddressTagDto $addressTag): void
    {
        $this->addressTag = $addressTag;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }
    public function setCompany(?string $company): void
    {
        $this->company = $company;
    }

    public function getPostOfficeBox(): ?string
    {
        return $this->postOfficeBox;
    }

    public function setPostOfficeBox(?string $postOfficeBox): void
    {
        $this->postOfficeBox = $postOfficeBox;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): void
    {
        $this->postcode = $postcode;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): void
    {
        $this->street = $street;
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

    static public function fromArray(array $data): PostAddressDto
    {
        $dto = new self();
        $dto->setAddressAddition($data['addressAddition'] ?? null);
        $dto->setAddressTag(AddressTagDto::fromArray($data['addressTag']) ?? null);
        $dto->setCity($data['city'] ?? null);
        $dto->setCountry($data['country'] ?? null);
        $dto->setPostOfficeBox($data['postOfficeBox'] ?? null);
        $dto->setPostcode($data['postcode'] ?? null);
        $dto->setState($data['state'] ?? null);
        $dto->setStreet($data['street'] ?? null);
        $dto->setValidFrom(isset($data['validFrom']) ? new \DateTime($data['validFrom']) : null);
        $dto->setValidTo(isset($data['validTo']) ? new \DateTime($data['validTo']) : null);

        return $dto;
    }
}
