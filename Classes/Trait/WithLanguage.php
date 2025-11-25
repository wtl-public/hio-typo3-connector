<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\LanguageDto;

trait WithLanguage
{
    protected ?LanguageDto $language;

    public function getLanguage(): ?LanguageDto
    {
        return $this->language;
    }

    public function setLanguage(?LanguageDto $language): void
    {
        $this->language = $language;
    }
}
