<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

use Wtl\HioTypo3Connector\Domain\Dto\NominationDto;

class ReceiveHioNominationEvent
{
    public function __construct(private readonly NominationDto $hioNomination, private readonly int $storagePid)
    {}

    public function getHioNomination(): NominationDto
    {
        return $this->hioNomination;
    }

    public function getStoragePid(): int
    {
        return $this->storagePid;
    }
}
