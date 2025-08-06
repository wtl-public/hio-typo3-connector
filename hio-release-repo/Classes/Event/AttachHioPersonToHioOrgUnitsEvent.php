<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioPersonToHioOrgUnitsEvent
{
    public function __construct(
        protected readonly int $hioPersonObjectId,
        protected readonly array $hioOrgUnitObjectIds
    )
    {
    }

    public function getHioPersonObjectId(): int
    {
        return $this->hioPersonObjectId;
    }

    public function getHioOrgUnitObjectIds(): array
    {
        return $this->hioOrgUnitObjectIds;
    }
}
