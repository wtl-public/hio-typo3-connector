<?php

namespace Unit\Domain\Dto;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Wtl\HioTypo3Connector\Domain\Dto\Nomination\PrizeDto as NominationPrizeDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\DoctoralProgramDto as OrgUnitDoctoralProgramDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\HabilitationDto as OrgUnitHabilitationDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\PatentDto as OrgUnitPatentDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\PrizeDto as OrgUnitPrizeDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\ProjectDto as OrgUnitProjectDto;
use Wtl\HioTypo3Connector\Domain\Dto\Patent\PriorityPatentDto;
use Wtl\HioTypo3Connector\Domain\Dto\Person\DoctoralProgramDto as PersonDoctoralProgramDto;
use Wtl\HioTypo3Connector\Domain\Dto\Person\HabilitationDto as PersonHabilitationDto;
use Wtl\HioTypo3Connector\Domain\Dto\Person\PatentDto as PersonPatentDto;
use Wtl\HioTypo3Connector\Domain\Dto\Person\ProjectDto as PersonProjectDto;
use Wtl\HioTypo3Connector\Domain\Dto\PublicationDto;

/**
 * A title is optional in the answer. These DTOs read it and hand it to
 * `setTitle(string $title)`, so a record without one stopped the import and every
 * record behind it stayed out. The empty string is what `WithTitle` starts with.
 */
class TitleFallbackTest extends TestCase
{
    /**
     * A publication carries its type as well. `PublicationDto::setPublicationType()`
     * takes no null, so the record needs one to reach the title at all.
     */
    public static function dtoProvider(): array
    {
        return [
            'publication' => [PublicationDto::class, ['publicationType' => ['id' => 2, 'name' => 'Artikel']]],
            'org unit doctoral programme' => [OrgUnitDoctoralProgramDto::class, []],
            'org unit habilitation' => [OrgUnitHabilitationDto::class, []],
            'org unit patent' => [OrgUnitPatentDto::class, []],
            'org unit prize' => [OrgUnitPrizeDto::class, []],
            'org unit project' => [OrgUnitProjectDto::class, []],
            'person doctoral programme' => [PersonDoctoralProgramDto::class, []],
            'person habilitation' => [PersonHabilitationDto::class, []],
            'person patent' => [PersonPatentDto::class, []],
            'person project' => [PersonProjectDto::class, []],
            'nomination prize' => [NominationPrizeDto::class, []],
            'priority patent' => [PriorityPatentDto::class, []],
        ];
    }

    #[Test]
    #[DataProvider('dtoProvider')]
    public function readsARecordWithoutATitle(string $dto, array $extra): void
    {
        self::assertSame('', $dto::fromArray(['id' => 1] + $extra)->getTitle());
    }

    #[Test]
    #[DataProvider('dtoProvider')]
    public function readsARecordWhoseTitleIsEmpty(string $dto, array $extra): void
    {
        self::assertSame('', $dto::fromArray(['id' => 1, 'title' => null] + $extra)->getTitle());
    }
}
