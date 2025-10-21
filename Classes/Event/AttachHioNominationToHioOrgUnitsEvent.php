<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioNominationToHioOrgUnitsEvent
{
    public function __construct(
        protected readonly int $hioNominationObjectId,
        protected readonly array $hioOrgUnitObjectIds
    )
    {
    }

    public function getHioNominationObjectId(): int
    {
        return $this->hioNominationObjectId;
    }

    public function getHioOrgUnitObjectIds(): array
    {
        return $this->hioOrgUnitObjectIds;
    }
}
