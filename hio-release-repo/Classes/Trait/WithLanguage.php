<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithLanguage
{
    protected string $language = '';

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }
}
