<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\OrgUnitRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioOrgUnitsEvent;

class AttachHioPersonToHioOrgUnitsListener
{
    public function __construct(
        protected readonly OrgUnitRepository  $orgUnitRepository,
        protected readonly PersonRepository   $personRepository,
        protected readonly PersistenceManager $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioPersonToHioOrgUnitsEvent $event): void
    {
        $person = $this->personRepository->findByObjectId($event->getHioPersonObjectId());
        if ($person === null) {
            return;
        }

        foreach ($event->getHioOrgUnitObjectIds() as $hioOrgUnitObjectId) {
            $orgUnit = $this->orgUnitRepository->findByObjectId($hioOrgUnitObjectId);
            if ($orgUnit === null) {
                continue;
            }
            $person->addOrgUnit($orgUnit);
            $this->personRepository->update($person);
            $this->persistenceManager->persistAll();
        }
    }
}
