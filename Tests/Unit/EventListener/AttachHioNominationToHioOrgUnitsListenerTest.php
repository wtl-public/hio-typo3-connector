<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\EventListener;

use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Event\AttachHioNominationToHioOrgUnitsEvent;
use Wtl\HioTypo3Connector\EventListener\AttachHioNominationToHioOrgUnitsListener;
use Wtl\HioTypo3Connector\Services\MmRelationService;

final class AttachHioNominationToHioOrgUnitsListenerTest extends UnitTestCase
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
                45,
                'tx_hiotypo3connector_domain_model_orgunit',
                [11, 12],
                'tx_hiotypo3connector_nomination_orgunit_mm',
                'org_units',
            );

        $event    = new AttachHioNominationToHioOrgUnitsEvent(45, [11, 12]);
        $listener = new AttachHioNominationToHioOrgUnitsListener($mmRelationService);

        $listener($event);
    }

    #[Test]
    public function invokeNeverCallsSyncOwnersOfRelated(): void
    {
        $mmRelationService = $this->createMock(MmRelationService::class);
        $mmRelationService->expects(self::never())->method('syncOwnersOfRelated');

        $listener = new AttachHioNominationToHioOrgUnitsListener($mmRelationService);
        $listener(new AttachHioNominationToHioOrgUnitsEvent(1, [2]));
    }
}

