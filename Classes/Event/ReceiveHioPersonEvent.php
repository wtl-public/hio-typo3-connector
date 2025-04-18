<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

use Wtl\HioTypo3Connector\Domain\Dto\PersonDto;

class ReceiveHioPersonEvent
{
    public function __construct(private readonly PersonDto $hioPerson, private readonly int $storagePid)
    {}

    public function getHioPerson(): PersonDto
    {
        return $this->hioPerson;
    }

    public function getStoragePid(): int
    {
        return $this->storagePid;
    }
}
