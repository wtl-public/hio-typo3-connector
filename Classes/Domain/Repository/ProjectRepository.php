<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Dto\ProjectDto;
use Wtl\HioTypo3Connector\Domain\Model\Project;

class ProjectRepository extends BaseRepository
{
    public function save(ProjectDto $projectDto, $storagePageId): void
    {
        $projectModel = $this->findOneBy(['objectId' => $projectDto->getObjectId()]);

        if ($projectModel === null) {
            $projectModel = new Project();
            $projectModel->setObjectId($projectDto->getObjectId());
            $projectModel->setTitle($projectDto->getTitle());
            $projectModel->setDetails($projectDto->getDetails());
            $projectModel->setSearchIndex($projectDto->getSearchIndex());
            $projectModel->setPid($storagePageId);

            $this->add($projectModel);
        } else {
            $projectModel->setObjectId($projectDto->getObjectId());
            $projectModel->setTitle($projectDto->getTitle());
            $projectModel->setDetails($projectDto->getDetails());
            $projectModel->setSearchIndex($projectDto->getSearchIndex());
            $this->update($projectModel);
        }
        $this->persistenceManager->persistAll();
    }
}
