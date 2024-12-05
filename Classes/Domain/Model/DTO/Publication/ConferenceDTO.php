<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO\Publication;

class ConferenceDTO
{
    protected string $name = '';
    protected  string $text = '';
    protected  ?string $city = null;
    protected  ?string $country = null;
    protected string $type = '';
    protected string $language = '';
    protected  string $startDate;
    protected  string $endDate;

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getText(): string
    {
        return $this->text;
    }
    public function setText(string $text): void
    {
        $this->text = $text;
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

    public function getType(): string
    {
        return $this->type;
    }
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }
    public function setStartDate(string $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }
    public function setEndDate(string $endDate): void
    {
        $this->endDate = $endDate;
    }

    static public function fromArray(array $data): self
    {
        $conferenceData = new self();
        $conferenceData->setName($data['name']);
        $conferenceData->setText($data['text']);
        $conferenceData->setCity($data['city'] ?? null);
        $conferenceData->setCountry($data['country'] ?? null);
        $conferenceData->setType($data['type']);
        $conferenceData->setLanguage($data['language']);
        $conferenceData->setStartDate($data['startDate']);
        $conferenceData->setEndDate($data['endDate']);

        return $conferenceData;
    }
}
