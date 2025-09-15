<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\DoctoralProgramRepository;
use Wtl\HioTypo3Connector\Domain\Repository\OrgUnitRepository;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioDoctoralProgramsEvent;

class AttachHioOrgUnitToHioDoctoralProgramsListener
{
    public function __construct(
        protected readonly DoctoralProgramRepository $doctoralProgramRepository,
        protected readonly OrgUnitRepository          $orgUnitRepository,
        protected readonly PersistenceManager        $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioOrgUnitToHioDoctoralProgramsEvent $event): void
    {
        $orgUnit = $this->orgUnitRepository->findByObjectId($event->getHioOrgUnitObjectId());
//        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($orgUnit, 'Received Org Unit event');
        if ($orgUnit === null) {
            return;
        }

        foreach ($event->getHioDoctoralProgramsObjectIds() as $hioDoctoralProgramsObjectId) {
            $doctoralProgram = $this->doctoralProgramRepository->findByObjectId($hioDoctoralProgramsObjectId);
            if ($doctoralProgram === null) {
                continue;
            }
            $orgUnit->addDoctoralProgram($doctoralProgram);
            $this->orgUnitRepository->update($orgUnit);
            $this->persistenceManager->persistAll();
        }
    }
}
