<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

use Wtl\HioTypo3Connector\Domain\Dto\ProjectDto;

class ReceiveHioProjectEvent
{
    public function __construct(private readonly ProjectDto $hioProject, private readonly int $storagePid)
    {}

    public function getHioProject(): ProjectDto
    {
        return $this->hioProject;
    }

    public function getStoragePid(): int
    {
        return $this->storagePid;
    }
}
