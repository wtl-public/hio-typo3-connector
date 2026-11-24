<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Scheduler;

use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Registry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Scheduler\Task\AbstractTask;
use TYPO3\CMS\Scheduler\Task\ExecuteSchedulableCommandTask;

trait WithImportResultTaskRepositoryTrait
{
    private const REGISTRY_NAMESPACE = 'hio_typo3_connector';

    public function addExecutionToTask(AbstractTask $task): int
    {
        $executionId = parent::addExecutionToTask($task);
        GeneralUtility::makeInstance(ImportResult::class)->begin();

        return $executionId;
    }

    public function removeExecutionOfTask(AbstractTask $task, int $executionID, array|string|null $failureReason = null): void
    {
        $result = GeneralUtility::makeInstance(ImportResult::class)->end();
        parent::removeExecutionOfTask($task, $executionID, $failureReason);

        if ($result === null || !$task instanceof ExecuteSchedulableCommandTask) {
            return;
        }

        $command = method_exists($task, 'getCommandIdentifier') ? $task->getCommandIdentifier() : $task->getTaskType();
        if (!preg_match('/^hio:[^:\s]+:import$/D', $command)) {
            return;
        }

        try {
            GeneralUtility::makeInstance(Registry::class)->set(
                self::REGISTRY_NAMESPACE,
                $this->registryKey($task->getTaskUid()),
                $result
            );
        } catch (\Throwable $exception) {
            GeneralUtility::makeInstance(LogManager::class)->getLogger(self::class)->error(
                'Could not store scheduler import statistics',
                ['task_uid' => $task->getTaskUid(), 'exception' => $exception]
            );
        }
    }

    public function getGroupedTasks(): array
    {
        $groups = parent::getGroupedTasks();
        $registry = GeneralUtility::makeInstance(Registry::class);
        $languageService = $GLOBALS['LANG'] ?? GeneralUtility::makeInstance(LanguageServiceFactory::class)->create('default');
        $label = $languageService->sL(
            'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:scheduler.import.lastResult'
        );

        $abortedLabel = $languageService->sL(
            'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:scheduler.import.abortedResult'
        );

        foreach ($groups['taskGroupsWithTasks'] as &$group) {
            foreach ($group['tasks'] as &$task) {
                $isImportTask = isset($task['taskType'])
                    ? preg_match('/^hio:[^:\s]+:import$/D', $task['taskType'])
                    : $task['class'] === ExecuteSchedulableCommandTask::class
                        && preg_match('/^hio:[^:\s]+:import(?:\s|$)/', $task['additionalInformation']);
                if (!$isImportTask) {
                    continue;
                }
                $result = $registry->get(self::REGISTRY_NAMESPACE, $this->registryKey($task['uid']));
                if (is_array($result)) {
                    $task['additionalInformation'] .= "\n" . sprintf(
                        ($result['completed'] ?? true) ? $label : $abortedLabel,
                        $result['imported'],
                        $result['failed']
                    );
                }
            }
            unset($task);
        }
        unset($group);

        return $groups;
    }

    private function registryKey(int $taskUid): string
    {
        return 'scheduler.importResult.' . $taskUid;
    }
}
