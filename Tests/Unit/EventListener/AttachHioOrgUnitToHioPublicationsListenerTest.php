<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioPublicationsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioOrgUnitToHioPublicationsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioOrgUnitToHioPublicationsListenerTest extends UnitTestCase
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
                30,
                'tx_hiotypo3connector_domain_model_publication',
                [201, 202, 203],
                'tx_hiotypo3connector_orgunit_publication_mm',
                'publications',
            );

        $event    = new AttachHioOrgUnitToHioPublicationsEvent(30, [201, 202, 203]);
        $listener = new AttachHioOrgUnitToHioPublicationsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioOrgUnitToHioPublicationsListener($mmRelationService);
        $listener(new AttachHioOrgUnitToHioPublicationsEvent(1, [2]));
    }
}

