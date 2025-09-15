<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioOrgUnitToHioPersonsEvent
{
    public function __construct(
        protected readonly int $hioOrgUnitObjectId,
        protected readonly array $hioPersonObjectIds
    )
    {
    }

    public function getHioOrgUnitObjectId(): int
    {
        return $this->hioOrgUnitObjectId;
    }

    public function getHioPersonObjectIds(): array
    {
        return $this->hioPersonObjectIds;
    }
}
