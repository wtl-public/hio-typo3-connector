<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\OrgUnitDto;

class HioOrgUnitService extends HioApiService
{
    public function getOrgUnits(int $page = 1): array
    {
        $apiResponse = $this->fetch($page);

        if ($apiResponse->getMeta()->getTotal() === 0) {
            return [];
        }

        $result = $apiResponse->getData();
        foreach ($result as $orgUnit) {
            $orgUnits[] = OrgUnitDto::fromArray($orgUnit);
        }
        return $orgUnits ?? [];
    }
}
