<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioOrgUnitToHioHabilitationsEvent
{
    public function __construct(
        protected readonly int $hioOrgUnitObjectId,
        protected readonly array $hioHabilitationObjectIds
    )
    {
    }

    public function getHioOrgUnitObjectId(): int
    {
        return $this->hioOrgUnitObjectId;
    }

    public function getHioHabilitationObjectIds(): array
    {
        return $this->hioHabilitationObjectIds;
    }
}
