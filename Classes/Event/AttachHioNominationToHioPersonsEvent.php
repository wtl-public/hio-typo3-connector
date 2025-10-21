<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioNominationToHioPersonsEvent
{
    public function __construct(
        protected readonly int $hioNominationObjectId,
        protected readonly array $hioPersonObjectIds
    )
    {
    }

    public function getHioNominationObjectId(): int
    {
        return $this->hioNominationObjectId;
    }

    public function getHioPersonObjectIds(): array
    {
        return $this->hioPersonObjectIds;
    }
}
