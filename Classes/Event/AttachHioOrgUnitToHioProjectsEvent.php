<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioOrgUnitToHioProjectsEvent
{
    public function __construct(
        protected readonly int $hioOrgUnitObjectId,
        protected readonly array $hioProjectObjectIds
    )
    {
    }

    public function getHioOrgUnitObjectId(): int
    {
        return $this->hioOrgUnitObjectId;
    }

    public function getHioProjectObjectIds(): array
    {
        return $this->hioProjectObjectIds;
    }
}
