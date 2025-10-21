<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Publication;

use Wtl\HioTypo3Connector\Trait\WithLanguage;
use Wtl\HioTypo3Connector\Trait\WithName;
use Wtl\HioTypo3Connector\Trait\WithType;

class ConferenceDto
{
    use WithName;
    use WithLanguage;
    use WithType;

    protected string $text = '';
    protected ?string $city = null;
    protected ?string $country = null;
    protected string $startDate;
    protected string $endDate;

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
        $conferenceData->setType($data['type'] ?? null);
        $conferenceData->setLanguage($data['language']);
        $conferenceData->setStartDate($data['startDate']);
        $conferenceData->setEndDate($data['endDate']);

        return $conferenceData;
    }
}
