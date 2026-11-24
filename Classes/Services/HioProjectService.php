<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\ProjectDto;

class HioProjectService extends HioApiService
{
    /**
     * @param (callable(?int, \Throwable): void)|null $onMappingFailure
     * @return ProjectDto[]
     */
    public function getProjects(int $page = 1, ?callable $onMappingFailure = null): array
    {
        return $this->fetchMappedPage(
            $page,
            ProjectDto::fromArray(...),
            $onMappingFailure
        );
    }
}
