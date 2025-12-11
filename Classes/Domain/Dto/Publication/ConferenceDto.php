<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Publication;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\CountryDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\LanguageDto;
use Wtl\HioTypo3Connector\Domain\Dto\Publication\Conference\ConferenceEventTypeDto;
use Wtl\HioTypo3Connector\Trait\WithLanguage;
use Wtl\HioTypo3Connector\Trait\WithName;

class ConferenceDto
{
    use WithName;
    use WithLanguage;

    protected string $text = '';
    protected ?string $city = null;
    protected ?ConferenceEventTypeDto $conferenceEventType;
    protected ?CountryDto $country;
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

    public function getConferenceEventType(): ?ConferenceEventTypeDto
    {
        return $this->conferenceEventType;
    }
    public function setConferenceEventType(?ConferenceEventTypeDto $conferenceEventType): void
    {
        $this->conferenceEventType = $conferenceEventType;
    }


    public function getCountry(): ?CountryDto
    {
        return $this->country;
    }

    public function setCountry(?CountryDto $country): void
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
        $conferenceData->setCity($data['city'] ?? null);
        $conferenceData->setConferenceEventType(isset($data['conferenceEventType']) ? ConferenceEventTypeDto::fromArray($data['conferenceEventType']) : null);
        $conferenceData->setCountry(isset($data['country']) ? CountryDto::fromArray($data['country']) : null);
        $conferenceData->setEndDate($data['endDate'] ?? '');
        $conferenceData->setLanguage(isset($data['language']) ? LanguageDto::fromArray($data['language']) : null);
        $conferenceData->setName($data['name'] ?? '');
        $conferenceData->setStartDate($data['startDate'] ?? '');
        $conferenceData->setText($data['text'] ?? '');

        return $conferenceData;
    }
}
