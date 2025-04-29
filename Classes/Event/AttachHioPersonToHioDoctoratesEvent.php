<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

class AttachHioPersonToHioDoctoratesEvent
{
    public function __construct(
        protected readonly int $hioPersonObjectId,
        protected readonly array $hioDoctorateObjectIds
    )
    {
    }

    public function getHioPersonObjectId(): int
    {
        return $this->hioPersonObjectId;
    }

    public function getHioDoctorateObjectIds(): array
    {
        return $this->hioDoctorateObjectIds;
    }
}
