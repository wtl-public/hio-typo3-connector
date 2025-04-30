<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioPersonToHioDoctoralProgramsEvent
{
    public function __construct(
        protected readonly int $hioPersonObjectId,
        protected readonly array $hioDoctoralProgramsObjectIds
    )
    {
    }

    public function getHioPersonObjectId(): int
    {
        return $this->hioPersonObjectId;
    }

    public function getHioDoctoralProgramsObjectIds(): array
    {
        return $this->hioDoctoralProgramsObjectIds;
    }
}
