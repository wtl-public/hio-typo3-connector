<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioPatentsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioPersonToHioPatentsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioPersonToHioPatentsListenerTest extends UnitTestCase
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
                11,
                'tx_hiotypo3connector_domain_model_patent',
                [301, 302],
                'tx_hiotypo3connector_person_patent_mm',
                'patents',
            );

        $event    = new AttachHioPersonToHioPatentsEvent(11, [301, 302]);
        $listener = new AttachHioPersonToHioPatentsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioPersonToHioPatentsListener($mmRelationService);
        $listener(new AttachHioPersonToHioPatentsEvent(1, [2]));
    }
}

