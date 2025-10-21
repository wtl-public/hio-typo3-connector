<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithType
{
    protected ?string $type;

    public function getType(): string|null
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }
}
