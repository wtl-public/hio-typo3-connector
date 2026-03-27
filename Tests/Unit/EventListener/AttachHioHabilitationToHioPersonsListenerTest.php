<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioHabilitationToHioPersonsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioHabilitationToHioPersonsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioHabilitationToHioPersonsListenerTest extends UnitTestCase
{
    #[Test]
    public function invokeCallsSyncOwnersOfRelatedWithCorrectArguments(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService
            ->expects(self::once())
            ->method('syncOwnersOfRelated')
            ->with(
                'tx_hiotypo3connector_domain_model_person',
                [9, 10],
                'tx_hiotypo3connector_domain_model_habilitation',
                450,
                'tx_hiotypo3connector_person_habilitation_mm',
                'habilitations',
            );

        $event    = new AttachHioHabilitationToHioPersonsEvent(450, [9, 10]);
        $listener = new AttachHioHabilitationToHioPersonsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncRelationsOfOwner(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncRelationsOfOwner');

        $listener = new AttachHioHabilitationToHioPersonsListener($mmRelationService);
        $listener(new AttachHioHabilitationToHioPersonsEvent(1, [2]));
    }
}

