<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\OrgUnitRepository;
use Wtl\HioTypo3Connector\Domain\Repository\ProjectRepository;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioProjectsEvent;

class AttachHioOrgUnitToHioProjectsListener
{
    public function __construct(
        protected readonly ProjectRepository            $projectRepository,
        protected readonly OrgUnitRepository           $orgUnitRepository,
        protected readonly PersistenceManager        $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioOrgUnitToHioProjectsEvent $event): void
    {
        $orgUnit = $this->orgUnitRepository->findByObjectId($event->getHioOrgUnitObjectId());
        if ($orgUnit === null) {
            return;
        }

        foreach ($event->getHioProjectObjectIds() as $hioProjectObjectId) {
            $project = $this->projectRepository->findByObjectId($hioProjectObjectId);
            if ($project === null) {
                continue;
            }
            $orgUnit->addProject($project);
            $this->orgUnitRepository->update($orgUnit);
            $this->persistenceManager->persistAll();
        }
    }
}
