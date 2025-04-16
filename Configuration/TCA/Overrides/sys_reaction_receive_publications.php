<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

if (ExtensionManagementUtility::isLoaded('reactions')) {
    var_dump('Hallo');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
        'sys_reaction',
        [
            'storage_pid' => [
                'label' => 'LLL:EXT:reactions/Resources/Private/Language/locallang_db.xlf:sys_reaction.storage_pid',
                'description' => 'LLL:EXT:reactions/Resources/Private/Language/locallang_db.xlf:sys_reaction.storage_pid.description',
                'config' => [
                    'type' => 'group',
                    'allowed' => 'pages',
                    'size' => 1,
                    'maxitems' => 1,
                ],
            ],
        ]
    );

    // Add the custom type to the type select
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
        'sys_reaction',
        'reaction_type',
        [
            \Wtl\HioTypo3Connector\Reaction\ReceivePublicationsReaction::getDescription(),
            \Wtl\HioTypo3Connector\Reaction\ReceivePublicationsReaction::getType(),
            \Wtl\HioTypo3Connector\Reaction\ReceivePublicationsReaction::getIconIdentifier(),
        ]
    );

    $GLOBALS['TCA']['sys_reaction']['palettes']['createRecord'] = [
        'label' => 'LLL:EXT:reactions/Resources/Private/Language/locallang_db.xlf:palette.additional',
        'showitem' => 'storage_pid',
    ];
}
