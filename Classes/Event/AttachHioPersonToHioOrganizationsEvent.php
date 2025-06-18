<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioPersonToHioOrganizationsEvent
{
    public function __construct(
        protected readonly int $hioPersonObjectId,
        protected readonly array $hioOrganizationObjectIds
    )
    {
    }

    public function getHioPersonObjectId(): int
    {
        return $this->hioPersonObjectId;
    }

    public function getHioOrganizationsObjectIds(): array
    {
        return $this->hioOrganizationObjectIds;
    }
}
