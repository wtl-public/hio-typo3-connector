<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

use Wtl\HioTypo3Connector\Domain\Dto\PatentDto;

class ReceiveHioPatentEvent
{
    public function __construct(private readonly PatentDto $hioPatent, private readonly int $storagePid)
    {}

    public function getHioPatent(): PatentDto
    {
        return $this->hioPatent;
    }

    public function getStoragePid(): int
    {
        return $this->storagePid;
    }
}
