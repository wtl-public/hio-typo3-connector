<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\ProjectDto;

class HioProjectService extends HioApiService
{
    public function getProjects(int $page = 1): array
    {
        $apiResponse = $this->fetch($page);

        if ($apiResponse->getMeta()->getTotal() === 0) {
            return [];
        }

        $result = $apiResponse->getData();
        foreach ($result as $project) {
            $projects[] = ProjectDto::fromArray($project);
        }
        return $projects ?? [];
    }
}
