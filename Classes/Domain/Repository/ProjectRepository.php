<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Dto\ProjectDto;
use Wtl\HioTypo3Connector\Domain\Model\Project;

class ProjectRepository extends BaseRepository
{
    public function saveProjects($projects, $storagePageId): void {
        /** @var ProjectDto $project */
        foreach ($projects as $project) {
            $projectModel = $this->findOneBy(['objectId' => $project->getObjectId()]);

            if ($projectModel === null) {
                $projectModel = new Project();
                $projectModel->setObjectId($project->getObjectId());
                $projectModel->setTitle($project->getTitle());
                $projectModel->setDetails($project->getDetails());
                $projectModel->setSearchIndex($project->getSearchIndex());
                $projectModel->setPid($storagePageId);

                $this->add($projectModel);
            } else {
                $projectModel->setObjectId($project->getObjectId());
                $projectModel->setTitle($project->getTitle());
                $projectModel->setDetails($project->getDetails());
                $projectModel->setSearchIndex($project->getSearchIndex());
                $this->update($projectModel);
            }
        }
        $this->persistenceManager->persistAll();
    }
}
