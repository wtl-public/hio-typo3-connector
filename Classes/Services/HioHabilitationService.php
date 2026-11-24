<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\HabilitationDto;

class HioHabilitationService extends HioApiService
{
    /**
     * @param (callable(?int, \Throwable): void)|null $onMappingFailure
     * @return HabilitationDto[]
     */
    public function getHabilitations(int $page = 1, ?callable $onMappingFailure = null): array
    {
        return $this->fetchMappedPage(
            $page,
            HabilitationDto::fromArray(...),
            $onMappingFailure
        );
    }
}
