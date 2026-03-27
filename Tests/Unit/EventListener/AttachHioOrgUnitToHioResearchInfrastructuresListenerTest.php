<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioResearchInfrastructuresEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioOrgUnitToHioResearchInfrastructuresListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioOrgUnitToHioResearchInfrastructuresListenerTest extends UnitTestCase
{
    #[Test]
    public function invokeCallsSyncRelationsOfOwnerWithCorrectArguments(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService
            ->expects(self::once())
            ->method('syncRelationsOfOwner')
            ->with(
                'tx_hiotypo3connector_domain_model_orgunit',
                70,
                'tx_hiotypo3connector_domain_model_researchinfrastructure',
                [901, 902, 903],
                'tx_hiotypo3connector_orgunit_researchinfrastructure_mm',
                'research_infrastructures',
            );

        $event    = new AttachHioOrgUnitToHioResearchInfrastructuresEvent(70, [901, 902, 903]);
        $listener = new AttachHioOrgUnitToHioResearchInfrastructuresListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioOrgUnitToHioResearchInfrastructuresListener($mmRelationService);
        $listener(new AttachHioOrgUnitToHioResearchInfrastructuresEvent(1, [2]));
    }
}

