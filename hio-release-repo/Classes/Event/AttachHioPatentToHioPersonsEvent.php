<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioPatentToHioPersonsEvent
{
    public function __construct(
        protected readonly int $hioPatentObjectId,
        protected readonly array $hioPersonObjectIds
    )
    {
    }

    public function getHioPatentObjectId(): int
    {
        return $this->hioPatentObjectId;
    }

    public function getHioPersonObjectIds(): array
    {
        return $this->hioPersonObjectIds;
    }
}
