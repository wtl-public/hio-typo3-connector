<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

use Wtl\HioTypo3Connector\Domain\Dto\DoctorateDto;

class ReceiveHioDoctorateEvent
{
    public function __construct(private readonly DoctorateDto $hioDoctorate, private readonly int $storagePid)
    {}

    public function getHioDoctorate(): DoctorateDto
    {
        return $this->hioDoctorate;
    }

    public function getStoragePid(): int
    {
        return $this->storagePid;
    }
}
