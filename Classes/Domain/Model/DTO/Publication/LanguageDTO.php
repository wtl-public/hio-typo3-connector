<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO\Publication;

class LanguageDTO
{
    protected string $isoCode = '';
    protected string $name = '';

    public function getIsoCode(): string
    {
        return $this->isoCode;
    }
    public function setIsoCode(string $isoCode): void
    {
        $this->isoCode = $isoCode;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    static public function fromArray(array $data): self
    {
        $languageData = new self();
        $languageData->setIsoCode($data['iso_639_1']);
        $languageData->setName($data['name']);

        return $languageData;
    }
}
