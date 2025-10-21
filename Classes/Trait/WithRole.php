<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

trait WithRole
{
    protected ?string $role;

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): void
    {
        $this->role = $role;
    }
}
