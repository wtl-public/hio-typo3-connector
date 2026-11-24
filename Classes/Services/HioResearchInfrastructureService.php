<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructureDto;

class HioResearchInfrastructureService extends HioApiService
{
    /**
     * @param (callable(?int, \Throwable): void)|null $onMappingFailure
     * @return ResearchInfrastructureDto[]
     */
    public function getResearchInfrastructures(int $page = 1, ?callable $onMappingFailure = null): array
    {
        return $this->fetchMappedPage(
            $page,
            ResearchInfrastructureDto::fromArray(...),
            $onMappingFailure
        );
    }
}
