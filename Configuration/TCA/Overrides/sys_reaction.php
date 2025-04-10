<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

if (ExtensionManagementUtility::isLoaded('reactions')) {
    ExtensionManagementUtility::addTcaSelectItem(
        'sys_reaction',
        'table_name',
        [
            'label' => 'LLL:EXT:myext/Resources/Private/Language/locallang.xlf:tx_myextension_domain_model_mytable',
            'value' => 'tx_hiotypo3connector_domain_model_publication',
            'icon' => 'tx-hio_typo3_connector-list-of-publications',
        ]
    );
}
