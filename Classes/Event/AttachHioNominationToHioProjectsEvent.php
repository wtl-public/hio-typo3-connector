<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioNominationToHioProjectsEvent
{
    public function __construct(
        protected readonly int $hioNominationObjectId,
        protected readonly array $hioProjectObjectIds
    )
    {
    }

    public function getHioNominationObjectId(): int
    {
        return $this->hioNominationObjectId;
    }

    public function getHioProjectObjectIds(): array
    {
        return $this->hioProjectObjectIds;
    }
}
