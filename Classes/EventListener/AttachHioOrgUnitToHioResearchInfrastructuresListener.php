<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\EventListener;

use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Wtl\HioTypo3Connector\Domain\Repository\OrgUnitRepository;
use Wtl\HioTypo3Connector\Domain\Repository\ResearchInfrastructureRepository;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioResearchInfrastructuresEvent;

class AttachHioOrgUnitToHioResearchInfrastructuresListener
{
    public function __construct(
        protected readonly ResearchInfrastructureRepository             $researchInfrastructureRepository,
        protected readonly OrgUnitRepository           $orgUnitRepository,
        protected readonly PersistenceManager        $persistenceManager,
    )
    {
    }

    public function __invoke(AttachHioOrgUnitToHioResearchInfrastructuresEvent $event): void
    {
        $orgUnit = $this->orgUnitRepository->findByObjectId($event->getHioOrgUnitObjectId());
        if ($orgUnit === null) {
            return;
        }
//        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($orgUnit, 'Org Unit');
        foreach ($event->getHioResearchInfrastructureObjectIds() as $hioResearchInfrastructureObjectId) {
            $researchInfrastructure = $this->researchInfrastructureRepository->findByObjectId($hioResearchInfrastructureObjectId);
            if ($researchInfrastructure === null) {
                continue;
            }
            $orgUnit->addResearchInfrastructure($researchInfrastructure);
            $this->orgUnitRepository->update($orgUnit);
            $this->persistenceManager->persistAll();
        }
    }
}
