<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioHabilitationsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioPersonToHioHabilitationsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioPersonToHioHabilitationsListenerTest extends UnitTestCase
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
                55,
                'tx_hiotypo3connector_domain_model_habilitation',
                [401, 402, 403],
                'tx_hiotypo3connector_person_habilitation_mm',
                'habilitations',
            );

        $event    = new AttachHioPersonToHioHabilitationsEvent(55, [401, 402, 403]);
        $listener = new AttachHioPersonToHioHabilitationsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioPersonToHioHabilitationsListener($mmRelationService);
        $listener(new AttachHioPersonToHioHabilitationsEvent(1, [2]));
    }
}

