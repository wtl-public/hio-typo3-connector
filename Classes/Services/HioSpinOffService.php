<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\SpinOffDto;

class HioSpinOffService extends HioApiService
{
    /**
     * @param (callable(?int, \Throwable): void)|null $onMappingFailure
     * @return SpinOffDto[]
     */
    public function getSpinOffs(int $page = 1, ?callable $onMappingFailure = null): array
    {
        return $this->fetchMappedPage(
            $page,
            SpinOffDto::fromArray(...),
            $onMappingFailure
        );
    }
}
