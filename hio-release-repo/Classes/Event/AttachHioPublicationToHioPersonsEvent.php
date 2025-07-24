<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioPublicationToHioPersonsEvent
{
    public function __construct(protected readonly int $hioPublicationObjectId, protected readonly array $hioPersonObjectIds)
    {}

    public function getHioPublicationObjectId(): int
    {
        return $this->hioPublicationObjectId;
    }

    public function getHioPersonObjectIds(): array
    {
        return $this->hioPersonObjectIds;
    }
}
