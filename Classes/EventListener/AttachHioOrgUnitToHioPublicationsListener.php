<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\OrgUnitRepository;
use Wtl\HioTypo3Connector\Domain\Repository\ProjectRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PublicationRepository;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioProjectsEvent;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioPublicationsEvent;

class AttachHioOrgUnitToHioPublicationsListener
{
    public function __construct(
        protected readonly PublicationRepository     $publicationRepository,
        protected readonly OrgUnitRepository           $orgUnitRepository,
        protected readonly PersistenceManager        $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioOrgUnitToHioPublicationsEvent $event): void
    {
        $orgUnit = $this->orgUnitRepository->findByObjectId($event->getHioOrgUnitObjectId());
        if ($orgUnit === null) {
            return;
        }

        foreach ($event->getHioPublicationObjectIds() as $hioPublicationObjectId) {
            $publication = $this->publicationRepository->findByObjectId($hioPublicationObjectId);
            if ($publication === null) {
                continue;
            }
            $orgUnit->addPublication($publication);
            $this->orgUnitRepository->update($orgUnit);
            $this->persistenceManager->persistAll();
        }
    }
}
