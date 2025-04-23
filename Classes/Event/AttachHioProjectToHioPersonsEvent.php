<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioProjectToHioPersonsEvent
{
    public function __construct(
        protected readonly int $hioProjectObjectId,
        protected readonly array $hioPersonObjectIds
    )
    {
    }

    public function getHioProjectObjectId(): int
    {
        return $this->hioProjectObjectId;
    }

    public function getHioPersonObjectIds(): array
    {
        return $this->hioPersonObjectIds;
    }
}
