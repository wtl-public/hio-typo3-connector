<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\NominationDto;

class HioNominationService extends HioApiService
{
    /**
     * @param (callable(?int, \Throwable): void)|null $onMappingFailure
     * @return NominationDto[]
     */
    public function getNominations(int $page = 1, ?callable $onMappingFailure = null): array
    {
        return $this->fetchMappedPage(
            $page,
            NominationDto::fromArray(...),
            $onMappingFailure
        );
    }
}
