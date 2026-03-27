<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioOrgUnitsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioPersonToHioOrgUnitsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioPersonToHioOrgUnitsListenerTest extends UnitTestCase
{
    #[Test]
    public function invokeCallsSyncRelationsOfOwnerWithCorrectArguments(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService
            ->expects(self::once())
            ->method('syncRelationsOfOwner')
            ->with(
                'tx_hiotypo3connector_domain_model_person',
                42,
                'tx_hiotypo3connector_domain_model_orgunit',
                [5, 6],
                'tx_hiotypo3connector_person_orgunit_mm',
                'org_units',
            );

        $event    = new AttachHioPersonToHioOrgUnitsEvent(42, [5, 6]);
        $listener = new AttachHioPersonToHioOrgUnitsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioPersonToHioOrgUnitsListener($mmRelationService);
        $listener(new AttachHioPersonToHioOrgUnitsEvent(1, [2]));
    }
}

