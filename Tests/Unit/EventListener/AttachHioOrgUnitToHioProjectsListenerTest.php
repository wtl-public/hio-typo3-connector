<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioProjectsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioOrgUnitToHioProjectsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioOrgUnitToHioProjectsListenerTest extends UnitTestCase
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
                20,
                'tx_hiotypo3connector_domain_model_project',
                [110, 120],
                'tx_hiotypo3connector_orgunit_project_mm',
                'projects',
            );

        $event    = new AttachHioOrgUnitToHioProjectsEvent(20, [110, 120]);
        $listener = new AttachHioOrgUnitToHioProjectsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioOrgUnitToHioProjectsListener($mmRelationService);
        $listener(new AttachHioOrgUnitToHioProjectsEvent(1, [2]));
    }
}

