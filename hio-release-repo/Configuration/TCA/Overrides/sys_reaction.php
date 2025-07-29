<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

if (ExtensionManagementUtility::isLoaded('reactions')) {

    ExtensionManagementUtility::addTCAcolumns(
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

    $GLOBALS['TCA']['sys_reaction']['palettes']['createRecord'] = [
        'label' => 'LLL:EXT:reactions/Resources/Private/Language/locallang_db.xlf:palette.additional',
        'showitem' => 'storage_pid',
    ];
}
