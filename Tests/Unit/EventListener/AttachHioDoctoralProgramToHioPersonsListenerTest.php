<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioDoctoralProgramToHioPersonsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioDoctoralProgramToHioPersonsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioDoctoralProgramToHioPersonsListenerTest extends UnitTestCase
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
                [21, 22, 23],
                'tx_hiotypo3connector_domain_model_doctoralprogram',
                550,
                'tx_hiotypo3connector_person_doctoralprogram_mm',
                'doctoral_programs',
            );

        $event    = new AttachHioDoctoralProgramToHioPersonsEvent(550, [21, 22, 23]);
        $listener = new AttachHioDoctoralProgramToHioPersonsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncRelationsOfOwner(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncRelationsOfOwner');

        $listener = new AttachHioDoctoralProgramToHioPersonsListener($mmRelationService);
        $listener(new AttachHioDoctoralProgramToHioPersonsEvent(1, [2]));
    }
}

