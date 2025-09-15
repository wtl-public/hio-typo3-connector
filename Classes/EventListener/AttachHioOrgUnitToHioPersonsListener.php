<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\OrgUnitRepository;
use Wtl\HioTypo3Connector\Domain\Repository\PersonRepository;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioPersonsEvent;

class AttachHioOrgUnitToHioPersonsListener
{
    public function __construct(
        protected readonly OrgUnitRepository $orgUnitRepository,
        protected readonly PersonRepository $personRepository,
        protected readonly PersistenceManager $persistenceManager,
    )
    {
    }
    public function __invoke(AttachHioOrgUnitToHioPersonsEvent $event): void
    {
        $orgUnit = $this->orgUnitRepository->findByObjectId($event->getHioOrgUnitObjectId());
        if ($orgUnit === null) {
            return;
        }

        foreach ($event->getHioPersonObjectIds() as $hioPersonObjectId) {
            $person = $this->personRepository->findByObjectId($hioPersonObjectId);
            if ($person === null) {
                continue;
            }
            $person->addOrgUnit($orgUnit);
            $this->personRepository->update($person);
            $this->persistenceManager->persistAll();
        }
    }
}
