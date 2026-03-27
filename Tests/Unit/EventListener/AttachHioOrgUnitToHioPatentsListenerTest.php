<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioPatentsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioOrgUnitToHioPatentsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioOrgUnitToHioPatentsListenerTest extends UnitTestCase
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
                60,
                'tx_hiotypo3connector_domain_model_patent',
                [801, 802],
                'tx_hiotypo3connector_orgunit_patent_mm',
                'patents',
            );

        $event    = new AttachHioOrgUnitToHioPatentsEvent(60, [801, 802]);
        $listener = new AttachHioOrgUnitToHioPatentsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioOrgUnitToHioPatentsListener($mmRelationService);
        $listener(new AttachHioOrgUnitToHioPatentsEvent(1, [2]));
    }
}

