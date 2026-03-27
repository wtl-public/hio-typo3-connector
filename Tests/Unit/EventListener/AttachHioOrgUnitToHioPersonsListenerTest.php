<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioPersonsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioOrgUnitToHioPersonsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioOrgUnitToHioPersonsListenerTest extends UnitTestCase
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
                10,
                'tx_hiotypo3connector_domain_model_person',
                [1, 2, 3],
                'tx_hiotypo3connector_orgunit_person_mm',
                'persons',
            );

        $event    = new AttachHioOrgUnitToHioPersonsEvent(10, [1, 2, 3]);
        $listener = new AttachHioOrgUnitToHioPersonsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioOrgUnitToHioPersonsListener($mmRelationService);
        $listener(new AttachHioOrgUnitToHioPersonsEvent(1, [2]));
    }
}

