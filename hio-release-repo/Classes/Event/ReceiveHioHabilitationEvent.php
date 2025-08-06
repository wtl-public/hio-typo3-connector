<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

use Wtl\HioTypo3Connector\Domain\Dto\HabilitationDto;

class ReceiveHioHabilitationEvent
{
    public function __construct(private readonly HabilitationDto $hioHabilitation, private readonly int $storagePid)
    {}

    public function getHioHabilitation(): HabilitationDto
    {
        return $this->hioHabilitation;
    }

    public function getStoragePid(): int
    {
        return $this->storagePid;
    }
}
