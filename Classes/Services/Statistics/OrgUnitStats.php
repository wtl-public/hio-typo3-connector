<?php

namespace Wtl\HioTypo3Connector\Services\Statistics;

use Wtl\HioTypo3Connector\Domain\Model\OrgUnit;

class OrgUnitStats
{
    public function __construct(
    )
    {
    }

    public function getProjectCountByStatus(OrgUnit $orgUnit): array
    {
        $projects = $orgUnit->getProjects();
        $projectStatusCounts = [];
        foreach ($projects as $project) {
            $details = $project->getDetails();
            $projectStatus = $details['status']['name'] ?? 'Unknown';
            if (isset($projectStatusCounts[$projectStatus])) {
                $projectStatusCounts[$projectStatus]++;
            } else {
                $projectStatusCounts[$projectStatus] = 1;
            }
        }
        arsort($projectStatusCounts);
        return $projectStatusCounts;
    }
}
