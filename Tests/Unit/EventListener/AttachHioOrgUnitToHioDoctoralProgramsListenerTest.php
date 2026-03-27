<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioOrgUnitToHioDoctoralProgramsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioOrgUnitToHioDoctoralProgramsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioOrgUnitToHioDoctoralProgramsListenerTest extends UnitTestCase
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
                50,
                'tx_hiotypo3connector_domain_model_doctoralprogram',
                [701, 702],
                'tx_hiotypo3connector_orgunit_doctoralprogram_mm',
                'doctoral_programs',
            );

        $event    = new AttachHioOrgUnitToHioDoctoralProgramsEvent(50, [701, 702]);
        $listener = new AttachHioOrgUnitToHioDoctoralProgramsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioOrgUnitToHioDoctoralProgramsListener($mmRelationService);
        $listener(new AttachHioOrgUnitToHioDoctoralProgramsEvent(1, [2]));
    }
}

