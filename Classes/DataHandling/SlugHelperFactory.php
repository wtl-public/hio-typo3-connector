<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\DataHandling;

use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Creates configured SlugHelper instances for a given table and field.
 * Injectable as a DI service; isolates GeneralUtility::makeInstance from repositories.
 */
final class SlugHelperFactory
{
    public function create(string $table, string $field): SlugHelper
    {
        $config = $GLOBALS['TCA'][$table]['columns'][$field]['config'] ?? [];

        return GeneralUtility::makeInstance(SlugHelper::class, $table, $field, $config);
    }
}

