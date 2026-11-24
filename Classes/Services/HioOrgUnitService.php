<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\OrgUnitDto;

class HioOrgUnitService extends HioApiService
{
    /**
     * @param (callable(?int, \Throwable): void)|null $onMappingFailure
     * @return OrgUnitDto[]
     */
    public function getOrgUnits(int $page = 1, ?callable $onMappingFailure = null): array
    {
        return $this->fetchMappedPage(
            $page,
            OrgUnitDto::fromArray(...),
            $onMappingFailure
        );
    }
}
