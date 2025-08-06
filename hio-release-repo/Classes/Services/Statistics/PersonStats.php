<?php

namespace Wtl\HioTypo3Connector\Services\Statistics;

use Wtl\HioTypo3Connector\Domain\Model\Person;
use Wtl\HioTypo3Connector\Domain\Repository\ProjectRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PublicationRepository;

class PersonStats
{
    public function __construct(
        protected readonly PublicationRepository $publicationRepository,
        protected readonly ProjectRepository $projectRepository
    )
    {
    }

    public function getPublicationTypeStats(Person $person): array
    {
        return $this->publicationRepository->countPublicationsByTypeAndPerson($person);
    }

    public function getCoAuthorshipStats(Person $person): array
    {
        $publications = $this->publicationRepository->getPublicationsByPerson($person);
        $coAuthorships = [];
        /** @var \Wtl\HioTypo3Connector\Domain\Model\Publication $publication */
        foreach ($publications as $publication) {
            $details = $publication->getDetails();
            if (isset($details['persons']) && is_array($details['persons'])) {
                foreach ($details['persons'] as $coAuthor) {
                    if ($coAuthor['name'] === $person->getName()) {
                        continue; // Skip the person themselves
                    }
                    $coAuthorName = $coAuthor['name'] ?? 'Unknown';
                    if (isset($coAuthorships[$coAuthorName])) {
                        $coAuthorships[$coAuthorName]++;
                    } else {
                        $coAuthorships[$coAuthorName] = 1;
                    }
                }
            }
        }

        arsort($coAuthorships);
        return $coAuthorships;
    }

    public function getProjectCountByStatus(Person $person): array
    {
        $projects = $person->getProjects();
        $projectStatusCounts = [];
        foreach ($projects as $project) {
            $details = $project->getDetails();
            $projectStatus = $details['status'] ?? 'Unknown';
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
