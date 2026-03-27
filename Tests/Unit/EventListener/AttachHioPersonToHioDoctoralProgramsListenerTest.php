<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioPersonToHioDoctoralProgramsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioPersonToHioDoctoralProgramsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioPersonToHioDoctoralProgramsListenerTest extends UnitTestCase
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
                77,
                'tx_hiotypo3connector_domain_model_doctoralprogram',
                [501, 502],
                'tx_hiotypo3connector_person_doctoralprogram_mm',
                'doctoral_programs',
            );

        $event    = new AttachHioPersonToHioDoctoralProgramsEvent(77, [501, 502]);
        $listener = new AttachHioPersonToHioDoctoralProgramsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioPersonToHioDoctoralProgramsListener($mmRelationService);
        $listener(new AttachHioPersonToHioDoctoralProgramsEvent(1, [2]));
    }
}

