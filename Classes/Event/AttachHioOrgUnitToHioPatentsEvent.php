<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioOrgUnitToHioPatentsEvent
{
    public function __construct(
        protected readonly int $hioOrgUnitObjectId,
        protected readonly array $hioPatentObjectIds
    )
    {
    }

    public function getHioOrgUnitObjectId(): int
    {
        return $this->hioOrgUnitObjectId;
    }

    public function getHioPatentObjectIds(): array
    {
        return $this->hioPatentObjectIds;
    }
}
