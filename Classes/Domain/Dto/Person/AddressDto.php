<?php

namespace Wtl\HioTypo3Connector\Domain\Dto\Person;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\AddressTagDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\NotificationCategoryDto;

class AddressDto
{
    protected ?string $addressAddition = null;
    protected ?AddressTagDto $addressTag = null;
    protected ?string $city = null;
    protected ?string $country = null;
    protected ?string $email = null;
    protected ?string $hyperlink = null;
    protected ?string $messenger = null;
    protected ?NotificationCategoryDto $notificationCategory = null;
    protected ?string $phone = null;
    protected ?string $postOfficeBox = null;
    protected ?string $postcode = null;
    protected ?string $street = null;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getHyperlink(): ?string
    {
        return $this->hyperlink;
    }

    public function setHyperlink(?string $hyperlink): void
    {
        $this->hyperlink = $hyperlink;
    }

    public function getMessenger(): ?string
    {
        return $this->messenger;
    }

    public function setMessenger(?string $messenger): void
    {
        $this->messenger = $messenger;
    }

    public function getNotificationCategory(): ?NotificationCategoryDto
    {
        return $this->notificationCategory;
    }

    public function setNotificationCategory(?NotificationCategoryDto $notificationCategory): void
    {
        $this->notificationCategory = $notificationCategory;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
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

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    static public function fromArray(array $data): AddressDto
    {
        $dto = new self();
        $dto->setAddressAddition($data['addressAddition'] ?? null);
        if ($data['addressTag']) {
            $dto->setAddressTag(AddressTagDto::fromArray($data['addressTag']) ?? null);
        }
        $dto->setCity($data['city'] ?? null);
        $dto->setCountry($data['country'] ?? null);
        $dto->setEmail($data['email'] ?? null);
        $dto->setHyperlink($data['hyperlink'] ?? null);
        $dto->setMessenger($data['messenger'] ?? null);
        if ($data['notificationCategory']) {
            $dto->setNotificationCategory(NotificationCategoryDto::fromArray($data['notificationCategory']));
        }
        $dto->setPhone($data['phone'] ?? null);
        $dto->setPostOfficeBox($data['postOfficeBox'] ?? null);
        $dto->setPostcode($data['postcode'] ?? null);
        $dto->setStreet($data['street'] ?? null);

        return $dto;
    }
}
