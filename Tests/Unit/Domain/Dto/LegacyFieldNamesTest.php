<?php

namespace Unit\Domain\Dto;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Wtl\HioTypo3Connector\Domain\Dto\DoctoralProgramDto;
use Wtl\HioTypo3Connector\Domain\Dto\HabilitationDto;
use Wtl\HioTypo3Connector\Domain\Dto\ProjectDto;

/**
 * A site runs this extension against the middleware it has, so an answer arrives
 * under the current field names or under the ones before them. Both leave the DTO
 * in one shape, `details` included — a template reads one form and no other.
 */
class LegacyFieldNamesTest extends TestCase
{
    private const CURRENT = [
        'id' => 7,
        'description' => 'Was das Projekt tut',
        'projectType' => ['id' => 3, 'name' => 'Forschung', 'uniquename' => 'forschung'],
        'persons' => [['id' => 488, 'name' => 'Armin Graf', 'role' => ['id' => 1, 'name' => 'Projektleiter/-in']]],
    ];

    private const LEGACY = [
        'id' => 7,
        'abstract' => 'Was das Projekt tut',
        'type' => 'Forschung',
        'persons' => [['id' => 488, 'name' => 'Armin Graf', 'role' => 'Projektleiter/-in']],
    ];

    #[Test]
    public function readsBothAnswersIntoTheSameProject(): void
    {
        foreach (['current' => self::CURRENT, 'legacy' => self::LEGACY] as $answer => $data) {
            $project = ProjectDto::fromArray($data);

            self::assertSame('Was das Projekt tut', $project->getAbstract(), $answer);
            self::assertSame('Forschung', $project->getType(), $answer);
            self::assertSame('Projektleiter/-in', $project->getPersons()[0]->getRole(), $answer);
        }
    }

    #[Test]
    public function leavesBothAnswersAsTheSameDetails(): void
    {
        $current = ProjectDto::fromArray(self::CURRENT)->getDetails();
        $legacy = ProjectDto::fromArray(self::LEGACY)->getDetails();

        self::assertSame('Forschung', $legacy['projectType']['name']);
        self::assertSame('Was das Projekt tut', $legacy['description']);
        self::assertSame('Projektleiter/-in', $legacy['persons'][0]['role']['name']);

        // The order differs: a carried-over field lands at the end of the array.
        self::assertEqualsCanonicalizing(array_keys($current), array_keys($legacy));
        self::assertArrayNotHasKey('type', $legacy);
        self::assertArrayNotHasKey('abstract', $legacy);
    }

    /**
     * `ProjectDto::fromArray()` skips a person that is not an array, so one reaches
     * the normaliser too.
     */
    #[Test]
    public function passesAPersonThatIsNotAnArray(): void
    {
        $project = ProjectDto::fromArray(['id' => 7, 'persons' => ['Armin Graf', ['id' => 1, 'name' => 'Eva Roth']]]);

        self::assertSame('Armin Graf', $project->getDetails()['persons'][0]);
        self::assertCount(1, $project->getPersons());
    }

    #[Test]
    public function prefersTheCurrentNameOverTheLegacyOne(): void
    {
        $project = ProjectDto::fromArray([
            'id' => 7,
            'description' => 'Die neue Beschreibung',
            'abstract' => 'Die alte Beschreibung',
            'projectType' => ['id' => 3, 'name' => 'Forschung'],
            'type' => 'Lehre',
        ]);

        self::assertSame('Die neue Beschreibung', $project->getAbstract());
        self::assertSame('Forschung', $project->getType());
    }

    /**
     * A middleware that knows the current name says so even when the field is empty.
     * The legacy value beside it is then stale, and reading it would put content back
     * on a page the site has just emptied.
     */
    #[Test]
    public function keepsAnEmptyCurrentFieldOverTheLegacyOne(): void
    {
        $project = ProjectDto::fromArray([
            'id' => 7,
            'description' => null,
            'abstract' => 'Die alte Beschreibung',
        ]);

        self::assertSame('', $project->getAbstract());
        self::assertNull($project->getDetails()['description']);
        self::assertArrayNotHasKey('abstract', $project->getDetails());
    }

    /**
     * An empty legacy field is still an answer. Dropping its key without carrying it
     * over would leave `details` with neither name, and the one shape is the whole
     * point of this class.
     */
    #[Test]
    public function carriesAnEmptyLegacyFieldOverUnderTheCurrentName(): void
    {
        $details = ProjectDto::fromArray(['id' => 7, 'abstract' => null])->getDetails();

        self::assertArrayHasKey('description', $details);
        self::assertNull($details['description']);
        self::assertArrayNotHasKey('abstract', $details);
    }

    /**
     * `PersonController::habilitationListAction()` filters on the role in `details`. A
     * habilitation answer carries the bare name, so the normaliser is the only place
     * that gives the filter the object it reads.
     */
    #[Test]
    public function leavesTheHabilitationRoleAsAnObjectInDetails(): void
    {
        $persons = [['id' => 488, 'name' => 'Armin Graf', 'role' => 'doctoral']];

        $habilitation = [
            'id' => 9,
            'title' => 'Zur Statik weitgespannter Tragwerke',
            'habilitationType' => null,
            'persons' => $persons,
        ];

        $details = HabilitationDto::fromArray($habilitation)->getDetails();

        self::assertSame('doctoral', $details['persons'][0]['role']['name']);
    }

    #[Test]
    public function readsTheDoctoralProgrammeOrgUnitsUnderBothNames(): void
    {
        $unit = [['id' => 12, 'name' => 'Fachbereich Bauwesen']];

        $current = DoctoralProgramDto::fromArray(['id' => 4, 'orgUnits' => $unit]);
        $legacy = DoctoralProgramDto::fromArray(['id' => 4, 'organizations' => $unit]);

        self::assertSame('Fachbereich Bauwesen', $current->getOrgUnits()[0]->getName());
        self::assertSame('Fachbereich Bauwesen', $legacy->getOrgUnits()[0]->getName());
    }
}
