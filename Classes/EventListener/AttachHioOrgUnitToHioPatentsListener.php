<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\OrgUnitRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PatentRepository;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioPatentsEvent;

class AttachHioOrgUnitToHioPatentsListener
{
    public function __construct(
        protected readonly PatentRepository             $patentRepository,
        protected readonly OrgUnitRepository           $orgUnitRepository,
        protected readonly PersistenceManager        $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioOrgUnitToHioPatentsEvent $event): void
    {
        $orgUnit = $this->orgUnitRepository->findByObjectId($event->getHioOrgUnitObjectId());
        if ($orgUnit === null) {
            return;
        }

        foreach ($event->getHioPatentObjectIds() as $hioPatentObjectId) {
            $patent = $this->patentRepository->findByObjectId($hioPatentObjectId);
            if ($patent === null) {
                continue;
            }
            $orgUnit->addPatent($patent);
            $this->orgUnitRepository->update($orgUnit);
            $this->persistenceManager->persistAll();
        }
    }
}
