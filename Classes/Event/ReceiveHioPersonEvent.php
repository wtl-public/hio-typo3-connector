<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

use Wtl\HioTypo3Connector\Domain\Model\Dto\PersonDTO;

class ReceiveHioPersonEvent
{
    public function __construct(private readonly PersonDTO $hioPerson, private readonly int $storagePid)
    {}

    public function getHioPerson(): PersonDTO
    {
        return $this->hioPerson;
    }

    public function getStoragePid(): int
    {
        return $this->storagePid;
    }
}
