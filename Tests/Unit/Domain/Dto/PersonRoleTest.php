<?php

namespace Unit\Domain\Dto;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Wtl\HioTypo3Connector\Domain\Dto\DoctoralProgram\PersonDto as DoctoralProgramPersonDto;
use Wtl\HioTypo3Connector\Domain\Dto\Habilitation\PersonDto as HabilitationPersonDto;
use Wtl\HioTypo3Connector\Domain\Dto\Patent\PersonDto as PatentPersonDto;
use Wtl\HioTypo3Connector\Domain\Dto\Project\PersonDto as ProjectPersonDto;
use Wtl\HioTypo3Connector\Domain\Dto\Publication\PersonDto as PublicationPersonDto;

/**
 * A project delivers the role as an object, a doctoral programme as the bare name. Both
 * forms reach the same trait, and an import that rejects either one stops on the first
 * record that carries it.
 */
class PersonRoleTest extends TestCase
{
    public static function dtoProvider(): array
    {
        return [
            'project' => [ProjectPersonDto::class],
            'publication' => [PublicationPersonDto::class],
            'patent' => [PatentPersonDto::class],
            'doctoral programme' => [DoctoralProgramPersonDto::class],
            'habilitation' => [HabilitationPersonDto::class],
        ];
    }

    #[Test]
    #[DataProvider('dtoProvider')]
    public function readsTheRoleAsAnObject(string $dto): void
    {
        $person = $dto::fromArray([
            'id' => 488,
            'name' => 'Armin Graf',
            'role' => [
                'id' => 1,
                'name' => 'Projektleiter/-in',
                'uniquename' => 'projektleitung',
            ],
        ]);

        self::assertSame('Projektleiter/-in', $person->getRole());
    }

    #[Test]
    #[DataProvider('dtoProvider')]
    public function readsTheRoleAsAString(string $dto): void
    {
        $person = $dto::fromArray([
            'id' => 488,
            'name' => 'Armin Graf',
            'role' => 'Projektleiter/-in',
        ]);

        self::assertSame('Projektleiter/-in', $person->getRole());
    }

    #[Test]
    #[DataProvider('dtoProvider')]
    public function readsAPersonWithoutARole(string $dto): void
    {
        $person = $dto::fromArray(['id' => 488, 'name' => 'Armin Graf']);

        self::assertSame('Armin Graf', $person->getName());
        self::assertNull($person->getRole());
    }
}
