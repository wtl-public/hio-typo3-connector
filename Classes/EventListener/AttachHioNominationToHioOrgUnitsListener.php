<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\NominationRepository;
use Wtl\HioTypo3Connector\Domain\Repository\OrgUnitRepository;
use Wtl\HioTypo3Connector\Event\AttachHioNominationToHioOrgUnitsEvent;

class AttachHioNominationToHioOrgUnitsListener
{
    public function __construct(
        protected readonly NominationRepository $nominationRepository,
        protected readonly OrgUnitRepository $orgUnitRepository,
        protected readonly PersistenceManager $persistenceManager,
    )
    {
    }
    public function __invoke(AttachHioNominationToHioOrgUnitsEvent $event): void
    {
        $nomination = $this->nominationRepository->findByObjectId($event->getHioNominationObjectId());
        if ($nomination === null) {
            return;
        }

        foreach ($event->getHioOrgUnitObjectIds() as $hioOrgunitObjectId) {
            $orgUnit = $this->orgUnitRepository->findByObjectId($hioOrgunitObjectId);
            if ($orgUnit === null) {
                continue;
            }
            $nomination->addOrgUnit($orgUnit);
            $this->nominationRepository->update($nomination);
            $this->persistenceManager->persistAll();
        }
    }
}
