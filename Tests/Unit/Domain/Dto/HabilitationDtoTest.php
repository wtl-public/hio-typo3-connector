<?php

namespace Unit\Domain\Dto;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Wtl\HioTypo3Connector\Domain\Dto\HabilitationDto;

/**
 * The import reads one habilitation after the other, and a record that stops it stops
 * every record behind it. Three fields of the answer are optional, so all three arrive
 * missing sooner or later.
 */
class HabilitationDtoTest extends TestCase
{
    private const ORG_UNIT = ['id' => 12, 'name' => 'Fachbereich Bauwesen'];

    private const PERSON = ['id' => 488, 'name' => 'Armin Graf', 'role' => 'doctoral'];

    #[Test]
    public function readsAHabilitationWithoutATitle(): void
    {
        $habilitation = HabilitationDto::fromArray(['id' => 9]);

        self::assertSame('', $habilitation->getTitle());
    }

    #[Test]
    public function readsAHabilitationWithoutAType(): void
    {
        $habilitation = HabilitationDto::fromArray(['id' => 9, 'title' => 'Zur Statik weitgespannter Tragwerke']);

        self::assertNull($habilitation->getHabilitationTypeDto());
    }

    /**
     * The org units came from `persons` before, so a habilitation carried its candidate
     * and its supervisor as two org units and no org unit of the answer at all.
     */
    #[Test]
    public function readsTheOrgUnitsUnderTheirOwnName(): void
    {
        $habilitation = HabilitationDto::fromArray([
            'id' => 9,
            'title' => 'Zur Statik weitgespannter Tragwerke',
            'orgUnits' => [self::ORG_UNIT],
            'persons' => [self::PERSON],
        ]);

        self::assertCount(1, $habilitation->getOrgUnits());
        self::assertSame('Fachbereich Bauwesen', $habilitation->getOrgUnits()[0]->getName());
        self::assertSame('Armin Graf', $habilitation->getPersons()[0]->getName());
    }
}
