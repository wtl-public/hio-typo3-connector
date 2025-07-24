<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

use Wtl\HioTypo3Connector\Domain\Dto\DoctoralProgramDto;

class ReceiveHioDoctoralProgramEvent
{
    public function __construct(private readonly DoctoralProgramDto $hioDoctoralProgram, private readonly int $storagePid)
    {}

    public function getHioDoctoralProgram(): DoctoralProgramDto
    {
        return $this->hioDoctoralProgram;
    }

    public function getStoragePid(): int
    {
        return $this->storagePid;
    }
}
