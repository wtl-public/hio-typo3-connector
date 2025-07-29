<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

use Wtl\HioTypo3Connector\Domain\Dto\PublicationDto;

class ReceiveHioPublicationEvent
{
    public function __construct(private readonly PublicationDto $hioPublication, private readonly int $storagePid)
    {}

    public function getHioPublication(): PublicationDto
    {
        return $this->hioPublication;
    }

    public function getStoragePid(): int
    {
        return $this->storagePid;
    }
}
