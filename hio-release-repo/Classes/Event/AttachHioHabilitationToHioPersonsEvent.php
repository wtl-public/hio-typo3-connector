<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioHabilitationToHioPersonsEvent
{
    public function __construct(
        protected readonly int $hioHabilitationObjectId,
        protected readonly array $hioPersonObjectIds
    )
    {
    }

    public function getHioHabilitationObjectId(): int
    {
        return $this->hioHabilitationObjectId;
    }

    public function getHioPersonObjectIds(): array
    {
        return $this->hioPersonObjectIds;
    }
}
