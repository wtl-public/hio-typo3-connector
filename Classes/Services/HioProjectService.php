<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Model\DTO\ProjectDTO;

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
            $projectData  = new ProjectDTO();
            $projectData->setObjectId($project['id']);
            $projectData->setTitle($project['title'] ?? '');
            $projectData->setDetails($project);
            $projects[] = $projectData;
        }
        return $projects ?? [];
    }
}
