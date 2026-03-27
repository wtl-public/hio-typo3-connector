<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioPublicationsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioPersonToHioPublicationsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioPersonToHioPublicationsListenerTest extends UnitTestCase
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
                'tx_hiotypo3connector_domain_model_publication',
                [10, 20, 30],
                'tx_hiotypo3connector_person_publication_mm',
                'publications',
            );

        $event    = new AttachHioPersonToHioPublicationsEvent(42, [10, 20, 30]);
        $listener = new AttachHioPersonToHioPublicationsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeCallsSyncRelationsOfOwnerWithEmptyRelatedIds(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService
            ->expects(self::once())
            ->method('syncRelationsOfOwner')
            ->with(
                'tx_hiotypo3connector_domain_model_person',
                99,
                'tx_hiotypo3connector_domain_model_publication',
                [],
                'tx_hiotypo3connector_person_publication_mm',
                'publications',
            );

        $event    = new AttachHioPersonToHioPublicationsEvent(99, []);
        $listener = new AttachHioPersonToHioPublicationsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioPersonToHioPublicationsListener($mmRelationService);
        $listener(new AttachHioPersonToHioPublicationsEvent(1, [2]));
    }
}

