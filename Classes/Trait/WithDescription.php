<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithDescription
{
    protected ?string $description;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
