<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioPersonToHioPublicationsEvent
{
    public function __construct(protected readonly int $hioPersonObjectId, protected readonly array $hioPublicationObjectIds)
    {}

    public function getHioPersonObjectId(): int
    {
        return $this->hioPersonObjectId;
    }

    public function getHioPublicationObjectIds(): array
    {
        return $this->hioPublicationObjectIds;
    }
}
