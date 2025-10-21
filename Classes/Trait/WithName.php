<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithName
{
    protected string $name = '';

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
