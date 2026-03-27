<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioHabilitationsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioOrgUnitToHioHabilitationsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioOrgUnitToHioHabilitationsListenerTest extends UnitTestCase
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
                40,
                'tx_hiotypo3connector_domain_model_habilitation',
                [601, 602],
                'tx_hiotypo3connector_orgunit_habilitation_mm',
                'habilitations',
            );

        $event    = new AttachHioOrgUnitToHioHabilitationsEvent(40, [601, 602]);
        $listener = new AttachHioOrgUnitToHioHabilitationsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioOrgUnitToHioHabilitationsListener($mmRelationService);
        $listener(new AttachHioOrgUnitToHioHabilitationsEvent(1, [2]));
    }
}

