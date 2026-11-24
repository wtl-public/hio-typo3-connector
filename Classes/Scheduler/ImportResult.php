<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Scheduler;

use TYPO3\CMS\Core\SingletonInterface;

/**
 * Carries the result from the import command to the scheduler in the same process.
 */
final class ImportResult implements SingletonInterface
{
    /** @var list<array{imported: int, failed: int, completed: bool}> */
    private array $runs = [];

    public function begin(): void
    {
        $this->runs[] = ['imported' => 0, 'failed' => 0, 'completed' => false];
    }

    public function record(int $imported, int $failed, bool $completed = false): void
    {
        $index = array_key_last($this->runs);
        if ($index !== null) {
            $this->runs[$index] = ['imported' => $imported, 'failed' => $failed, 'completed' => $completed];
        }
    }

    /** @return array{imported: int, failed: int, completed: bool}|null */
    public function end(): ?array
    {
        return array_pop($this->runs);
    }
}
