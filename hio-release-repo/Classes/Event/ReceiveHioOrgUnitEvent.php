<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Event;

use Wtl\HioTypo3Connector\Domain\Dto\OrgUnitDto;

class ReceiveHioOrgUnitEvent
{
    public function __construct(private readonly OrgUnitDto $hioOrgUnit, private readonly int $storagePid)
    {}

    public function getHioOrgUnit(): OrgUnitDto
    {
        return $this->hioOrgUnit;
    }

    public function getStoragePid(): int
    {
        return $this->storagePid;
    }
}
