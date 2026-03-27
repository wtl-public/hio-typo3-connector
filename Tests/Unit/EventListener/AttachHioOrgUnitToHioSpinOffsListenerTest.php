<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioSpinOffsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioOrgUnitToHioSpinOffsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioOrgUnitToHioSpinOffsListenerTest extends UnitTestCase
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
                80,
                'tx_hiotypo3connector_domain_model_spinoff',
                [1001, 1002],
                'tx_hiotypo3connector_orgunit_spinoff_mm',
                'spin_offs',
            );

        $event    = new AttachHioOrgUnitToHioSpinOffsEvent(80, [1001, 1002]);
        $listener = new AttachHioOrgUnitToHioSpinOffsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioOrgUnitToHioSpinOffsListener($mmRelationService);
        $listener(new AttachHioOrgUnitToHioSpinOffsEvent(1, [2]));
    }
}

