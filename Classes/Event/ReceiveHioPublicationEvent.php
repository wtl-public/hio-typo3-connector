<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

use Wtl\HioTypo3Connector\Domain\Model\Dto\PublicationDTO;

class ReceiveHioPublicationEvent
{
    public function __construct(private readonly PublicationDTO $hioPublication, private readonly int $storagePid)
    {}

    public function getHioPublication(): PublicationDTO
    {
        return $this->hioPublication;
    }

    public function getStoragePid(): int
    {
        return $this->storagePid;
    }
}
