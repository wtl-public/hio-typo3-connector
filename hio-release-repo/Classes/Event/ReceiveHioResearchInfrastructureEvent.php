<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

use Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructureDto;

class ReceiveHioResearchInfrastructureEvent
{
    public function __construct(private readonly ResearchInfrastructureDto $hioResearchInfrastructure, private readonly int $storagePid)
    {}

    public function getHioResearchInfrastructure(): ResearchInfrastructureDto
    {
        return $this->hioResearchInfrastructure;
    }

    public function getStoragePid(): int
    {
        return $this->storagePid;
    }
}
