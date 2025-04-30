<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioDoctoralProgramToHioPersonsEvent
{
    public function __construct(
        protected readonly int   $hioDoctoralProgramObjectId,
        protected readonly array $hioPersonObjectIds
    )
    {
    }

    public function getHioDoctoralProgramObjectId(): int
    {
        return $this->hioDoctoralProgramObjectId;
    }

    public function getHioPersonObjectIds(): array
    {
        return $this->hioPersonObjectIds;
    }
}
