<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioPersonToHioPatentsEvent
{
    public function __construct(
        protected readonly int $hioPersonObjectId,
        protected readonly array $hioPatentObjectIds
    )
    {
    }

    public function getHioPersonObjectId(): int
    {
        return $this->hioPersonObjectId;
    }

    public function getHioPatentObjectIds(): array
    {
        return $this->hioPatentObjectIds;
    }
}
