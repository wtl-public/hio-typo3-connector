<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\OrgUnitRepository;
use Wtl\HioTypo3Connector\Domain\Repository\SpinOffRepository;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioSpinOffsEvent;

class AttachHioOrgUnitToHioSpinOffsListener
{
    public function __construct(
        protected readonly SpinOffRepository             $spinOffRepository,
        protected readonly OrgUnitRepository           $orgUnitRepository,
        protected readonly PersistenceManager        $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioOrgUnitToHioSpinOffsEvent $event): void
    {
        $orgUnit = $this->orgUnitRepository->findByObjectId($event->getHioOrgUnitObjectId());
        if ($orgUnit === null) {
            return;
        }

        foreach ($event->getHioSpinOffObjectIds() as $hioSpinOffObjectId) {
            $spinOff = $this->spinOffRepository->findByObjectId($hioSpinOffObjectId);
            if ($spinOff === null) {
                continue;
            }
            $orgUnit->addSpinOff($spinOff);
            $this->orgUnitRepository->update($orgUnit);
            $this->persistenceManager->persistAll();
        }
    }
}
