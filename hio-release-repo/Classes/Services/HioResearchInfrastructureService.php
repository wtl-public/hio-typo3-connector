<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructureDto;

class HioResearchInfrastructureService extends HioApiService
{
    public function getResearchInfrastructures(int $page = 1): array
    {
        $apiResponse = $this->fetch($page);

        if ($apiResponse->getMeta()->getTotal() === 0) {
            return [];
        }

        $result = $apiResponse->getData();
        foreach ($result as $researchInfrastructure) {
            $researchInfrastructures[] = ResearchInfrastructureDto::fromArray($researchInfrastructure);
        }
        return $researchInfrastructures ?? [];
    }
}
