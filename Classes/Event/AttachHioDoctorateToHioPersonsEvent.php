<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioDoctorateToHioPersonsEvent
{
    public function __construct(
        protected readonly int $hioDoctorateObjectId,
        protected readonly array $hioPersonObjectIds
    )
    {
    }

    public function getHioDoctorateObjectId(): int
    {
        return $this->hioDoctorateObjectId;
    }

    public function getHioPersonObjectIds(): array
    {
        return $this->hioPersonObjectIds;
    }
}
