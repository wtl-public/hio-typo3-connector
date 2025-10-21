<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithTitle
{
    protected string $title = '';

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
