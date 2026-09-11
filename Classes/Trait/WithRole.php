<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

use Wtl\HioTypo3Connector\Utility\DataUtility;

trait WithRole
{
    protected ?string $role = null;

    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * A project delivers the role as the `{id, name, uniquename}` object every other
     * taxonomy field carries; a doctoral programme and a habilitation still deliver the
     * bare name. Both arrive here, and both leave as the name.
     */
    public function setRole(mixed $role): void
    {
        $this->role = DataUtility::coerceString($role, 'name');
    }
}
