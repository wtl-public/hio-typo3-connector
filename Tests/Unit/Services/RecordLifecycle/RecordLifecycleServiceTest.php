<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Tests\Unit\Services\RecordLifecycle;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Wtl\HioTypo3Connector\Services\HioApiService;
use Wtl\HioTypo3Connector\Services\RecordLifecycle\RecordLifecycleRun;
use Wtl\HioTypo3Connector\Services\RecordLifecycle\RecordLifecycleService;

/**
 * Unit tests for RecordLifecycleService::startRun().
 *
 * Covers how the --with-trashed / --soft-delete-after-days / --hard-delete-after-days
 * options of the import commands turn into the settings of a RecordLifecycleRun.
 */
#[CoversClass(RecordLifecycleService::class)]
final class RecordLifecycleServiceTest extends UnitTestCase
{
    private const TABLE = 'tx_hiotypo3connector_domain_model_project';

    #[Test]
    public function startRun_withoutOptions_everythingIsOff(): void
    {
        $run = $this->startRun([]);

        self::assertSame(
            [
                'table' => self::TABLE,
                'storagePageId' => 42,
                'withTrashed' => false,
                'softDeleteAfterDays' => null,
                'hardDeleteAfterDays' => null,
            ],
            $this->readSettings($run, withTarget: true)
        );
    }

    public static function withTrashedProvider(): array
    {
        return [
            'without --with-trashed' => [[], false],
            'with --with-trashed' => [['--with-trashed' => true], true],
        ];
    }

    /**
     * @param array<string, mixed> $options
     */
    #[Test]
    #[DataProvider('withTrashedProvider')]
    public function startRun_tellsTheApiServiceWhetherToFetchTrashedRecords(array $options, bool $expected): void
    {
        $apiService = $this->createMock(HioApiService::class);
        $apiService->expects(self::once())->method('setWithTrashed')->with($expected);

        $this->startRun($options, $apiService);
    }

    #[Test]
    public function startRun_withTrashed_usesDefaultDays(): void
    {
        $run = $this->startRun(['--with-trashed' => true]);

        self::assertSame(
            ['withTrashed' => true, 'softDeleteAfterDays' => 7, 'hardDeleteAfterDays' => 30],
            $this->readSettings($run)
        );
    }

    #[Test]
    public function startRun_withTrashedAndSoftDays_overridesOnlySoftDays(): void
    {
        $run = $this->startRun(['--with-trashed' => true, '--soft-delete-after-days' => '14']);

        self::assertSame(
            ['withTrashed' => true, 'softDeleteAfterDays' => 14, 'hardDeleteAfterDays' => 30],
            $this->readSettings($run)
        );
    }

    #[Test]
    public function startRun_softDaysWithoutTrashed_leavesHardDeleteOff(): void
    {
        $run = $this->startRun(['--soft-delete-after-days' => '7']);

        self::assertSame(
            ['withTrashed' => false, 'softDeleteAfterDays' => 7, 'hardDeleteAfterDays' => null],
            $this->readSettings($run)
        );
    }

    #[Test]
    public function startRun_emptyDayValuesWithTrashed_fallBackToDefaults(): void
    {
        // An option given without a value (e.g. an empty field) counts as not given
        $run = $this->startRun([
            '--with-trashed' => true,
            '--soft-delete-after-days' => '',
            '--hard-delete-after-days' => '',
        ]);

        self::assertSame(
            ['withTrashed' => true, 'softDeleteAfterDays' => 7, 'hardDeleteAfterDays' => 30],
            $this->readSettings($run)
        );
    }

    public static function invalidDaysProvider(): array
    {
        return [
            'soft-delete-after-days = 0' => ['soft-delete-after-days', '0'],
            'soft-delete-after-days = 1.5' => ['soft-delete-after-days', '1.5'],
            'hard-delete-after-days = -1' => ['hard-delete-after-days', '-1'],
            'hard-delete-after-days = abc' => ['hard-delete-after-days', 'abc'],
        ];
    }

    #[Test]
    #[DataProvider('invalidDaysProvider')]
    public function startRun_invalidDays_throwsBeforeAnyRequest(string $option, string $value): void
    {
        $apiService = $this->createMock(HioApiService::class);
        $apiService->expects(self::never())->method(self::anything());

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('--' . $option);

        $this->startRun(['--with-trashed' => true, '--' . $option => $value], $apiService);
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    /**
     * Runs startRun() with the import commands' argument/option definition, storage page '42'.
     *
     * @param array<string, mixed> $options e.g. ['--with-trashed' => true]
     */
    private function startRun(array $options, ?HioApiService $apiService = null): RecordLifecycleRun
    {
        $definition = new InputDefinition([
            new InputArgument('storagePageId', InputArgument::REQUIRED),
            new InputOption('with-trashed', null, InputOption::VALUE_NONE),
            new InputOption('soft-delete-after-days', null, InputOption::VALUE_REQUIRED),
            new InputOption('hard-delete-after-days', null, InputOption::VALUE_REQUIRED),
        ]);
        $input = new ArrayInput(['storagePageId' => '42'] + $options, $definition);

        return (new RecordLifecycleService($this->createStub(ConnectionPool::class)))->startRun(
            $apiService ?? $this->createStub(HioApiService::class),
            self::TABLE,
            $input
        );
    }

    /**
     * The run keeps its settings private; no cheap behaviour exposes the day values.
     *
     * @return array<string, mixed> withTrashed, softDeleteAfterDays, hardDeleteAfterDays (and table, storagePageId)
     */
    private function readSettings(RecordLifecycleRun $run, bool $withTarget = false): array
    {
        $properties = ['withTrashed', 'softDeleteAfterDays', 'hardDeleteAfterDays'];
        if ($withTarget) {
            $properties = ['table', 'storagePageId', ...$properties];
        }
        $settings = [];
        foreach ($properties as $property) {
            $settings[$property] = (new \ReflectionProperty($run, $property))->getValue($run);
        }

        return $settings;
    }
}
