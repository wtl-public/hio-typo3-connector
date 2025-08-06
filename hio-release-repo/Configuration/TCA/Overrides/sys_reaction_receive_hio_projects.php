<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

if (ExtensionManagementUtility::isLoaded('reactions')) {

    // Add the custom type to the type select
    ExtensionManagementUtility::addTcaSelectItem(
        'sys_reaction',
        'reaction_type',
        [
            \Wtl\HioTypo3Connector\Reaction\ReceiveHioProjectsReaction::getDescription(),
            \Wtl\HioTypo3Connector\Reaction\ReceiveHioProjectsReaction::getType(),
            \Wtl\HioTypo3Connector\Reaction\ReceiveHioProjectsReaction::getIconIdentifier(),
        ]
    );

    $GLOBALS['TCA']['sys_reaction']['types'][\Wtl\HioTypo3Connector\Reaction\ReceiveHioProjectsReaction::getType()] = [
        'showitem' => '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        --palette--;;config,
        --palette--;;createRecord,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
        --palette--;;access',
    ];
}
