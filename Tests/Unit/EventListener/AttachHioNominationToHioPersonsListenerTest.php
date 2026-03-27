<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioNominationToHioPersonsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioNominationToHioPersonsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioNominationToHioPersonsListenerTest extends UnitTestCase
{
    #[Test]
    public function invokeCallsSyncRelationsOfOwnerWithCorrectArguments(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService
            ->expects(self::once())
            ->method('syncRelationsOfOwner')
            ->with(
                'tx_hiotypo3connector_domain_model_nomination',
                15,
                'tx_hiotypo3connector_domain_model_person',
                [3, 4, 5],
                'tx_hiotypo3connector_nomination_person_mm',
                'nominees',
            );

        $event    = new AttachHioNominationToHioPersonsEvent(15, [3, 4, 5]);
        $listener = new AttachHioNominationToHioPersonsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioNominationToHioPersonsListener($mmRelationService);
        $listener(new AttachHioNominationToHioPersonsEvent(1, [2]));
    }
}

