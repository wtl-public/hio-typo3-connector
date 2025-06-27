<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioPersonToHioProjectsEvent
{
    public function __construct(
        protected readonly int $hioPersonObjectId,
        protected readonly array $hioProjectObjectIds
    )
    {
    }

    public function getHioPersonObjectId(): int
    {
        return $this->hioPersonObjectId;
    }

    public function getHioProjectObjectIds(): array
    {
        return $this->hioProjectObjectIds;
    }
}
