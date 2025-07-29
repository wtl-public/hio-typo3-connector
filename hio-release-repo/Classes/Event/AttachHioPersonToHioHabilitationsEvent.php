<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioPersonToHioHabilitationsEvent
{
    public function __construct(
        protected readonly int $hioPersonObjectId,
        protected readonly array $hioHabilitationObjectIds
    )
    {
    }

    public function getHioPersonObjectId(): int
    {
        return $this->hioPersonObjectId;
    }

    public function getHioHabilitationObjectIds(): array
    {
        return $this->hioHabilitationObjectIds;
    }
}
