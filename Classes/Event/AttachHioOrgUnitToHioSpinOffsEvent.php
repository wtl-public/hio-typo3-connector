<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioOrgUnitToHioSpinOffsEvent
{
    public function __construct(
        protected readonly int $hioOrgUnitObjectId,
        protected readonly array $hioSpinOffObjectIds
    )
    {
    }

    public function getHioOrgUnitObjectId(): int
    {
        return $this->hioOrgUnitObjectId;
    }

    public function getHioSpinOffObjectIds(): array
    {
        return $this->hioSpinOffObjectIds;
    }
}
