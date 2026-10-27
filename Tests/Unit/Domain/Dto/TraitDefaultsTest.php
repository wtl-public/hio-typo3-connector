<?php

namespace Unit\Domain\Dto;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Wtl\HioTypo3Connector\Domain\Dto\HabilitationDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnitDto;
use Wtl\HioTypo3Connector\Domain\Dto\Project\BudgetSourceDto;
use Wtl\HioTypo3Connector\Trait\WithDescription;
use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithLanguage;
use Wtl\HioTypo3Connector\Trait\WithStatus;
use Wtl\HioTypo3Connector\Trait\WithType;
use Wtl\HioTypo3Connector\Trait\WithVisibility;

/**
 * A field these traits carry is optional, so an answer without it never calls the
 * setter. A typed field without a default is uninitialized until then, and PHP stops
 * the request on the first read. The default makes the absent field read as null.
 */
class TraitDefaultsTest extends TestCase
{
    public static function traitProvider(): array
    {
        return [
            'WithDescription' => [new class {
                use WithDescription;
            }, 'getDescription'],
            'WithId' => [new class {
                use WithId;
            }, 'getId'],
            'WithLanguage' => [new class {
                use WithLanguage;
            }, 'getLanguage'],
            'WithStatus' => [new class {
                use WithStatus;
            }, 'getStatus'],
            'WithType' => [new class {
                use WithType;
            }, 'getType'],
            'WithVisibility' => [new class {
                use WithVisibility;
            }, 'getVisibility'],
        ];
    }

    #[Test]
    #[DataProvider('traitProvider')]
    public function readsTheFieldBeforeAnythingWritesIt(object $traitUser, string $getter): void
    {
        self::assertNull($traitUser->{$getter}());
    }

    /**
     * `HabilitationDto::fromArray()` calls neither setter, so a habilitation reads both
     * fields in this state and no other.
     */
    #[Test]
    public function readsTheLanguageAndTheStatusOfAHabilitation(): void
    {
        $habilitation = HabilitationDto::fromArray([
            'id' => 9,
            'title' => 'Zur Statik weitgespannter Tragwerke',
            'habilitationType' => null,
        ]);

        self::assertNull($habilitation->getLanguage());
        self::assertNull($habilitation->getStatus());
    }

    /**
     * `BudgetSourceDto::fromArray()` calls no status setter either.
     */
    #[Test]
    public function readsTheStatusOfABudgetSource(): void
    {
        self::assertNull(BudgetSourceDto::fromArray(['id' => 3])->getStatus());
    }

    /**
     * `OrgUnitDto` carries the getter and the setter of its address, and carried no
     * field. `setAddress()` wrote a dynamic property, which PHP 8.2 deprecates.
     */
    #[Test]
    public function readsTheAddressOfAnOrgUnit(): void
    {
        self::assertNull((new OrgUnitDto())->getAddress());
    }
}
