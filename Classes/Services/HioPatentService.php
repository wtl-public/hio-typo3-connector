<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\PatentDto;

class HioPatentService extends HioApiService
{
    /**
     * @param (callable(?int, \Throwable): void)|null $onMappingFailure
     * @return PatentDto[]
     */
    public function getPatents(int $page = 1, ?callable $onMappingFailure = null): array
    {
        return $this->fetchMappedPage(
            $page,
            PatentDto::fromArray(...),
            $onMappingFailure
        );
    }
}
