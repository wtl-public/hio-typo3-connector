<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Publication;

use Wtl\HioTypo3Connector\Trait\WithName;

class LanguageDto
{
    use WithName;

    protected string $isoCode = '';

    public function getIsoCode(): string
    {
        return $this->isoCode;
    }
    public function setIsoCode(string $isoCode): void
    {
        $this->isoCode = $isoCode;
    }

    static public function fromArray(array $data): self
    {
        $languageData = new self();
        $languageData->setIsoCode($data['iso_639_1']);
        $languageData->setName($data['name']);

        return $languageData;
    }
}
