<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

use Wtl\HioTypo3Connector\Domain\Dto\SpinOffDto;

class ReceiveHioSpinOffEvent
{
    public function __construct(private readonly SpinOffDto $hioSpinOff, private readonly int $storagePid)
    {}

    public function getHioSpinOff(): SpinOffDto
    {
        return $this->hioSpinOff;
    }

    public function getStoragePid(): int
    {
        return $this->storagePid;
    }
}
