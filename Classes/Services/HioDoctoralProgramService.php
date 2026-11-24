<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\DoctoralProgramDto;

class HioDoctoralProgramService extends HioApiService
{
    /**
     * @param (callable(?int, \Throwable): void)|null $onMappingFailure
     * @return DoctoralProgramDto[]
     */
    public function getDoctoralPrograms(int $page = 1, ?callable $onMappingFailure = null): array
    {
        return $this->fetchMappedPage(
            $page,
            DoctoralProgramDto::fromArray(...),
            $onMappingFailure
        );
    }
}
