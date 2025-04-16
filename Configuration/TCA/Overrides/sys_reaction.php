<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

if (ExtensionManagementUtility::isLoaded('reactions')) {

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

    ExtensionManagementUtility::addTcaSelectItem(
        'sys_reaction',
        'table_name',
        [
            'label' => 'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:tx_hiotypo3connector_domain_model_publication',
            'value' => 'tx_hiotypo3connector_domain_model_publication',
            'icon' => 'tx-hio_typo3_connector-list-of-publications',
        ]
    );
    ExtensionManagementUtility::addTcaSelectItem(
        'sys_reaction',
        'table_name',
        [
            'label' => 'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:tx_hiotypo3connector_domain_model_project',
            'value' => 'tx_hiotypo3connector_domain_model_project',
            'icon' => 'tx-hio_typo3_connector-list-of-projects',
        ]
    );
    ExtensionManagementUtility::addTcaSelectItem(
        'sys_reaction',
        'table_name',
        [
            'label' => 'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:tx_hiotypo3connector_domain_model_person',
            'value' => 'tx_hiotypo3connector_domain_model_person',
            'icon' => 'tx-hio_typo3_connector-list-of-persons',
        ]
    );
    ExtensionManagementUtility::addTcaSelectItem(
        'sys_reaction',
        'table_name',
        [
            'label' => 'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:tx_hiotypo3connector_domain_model_patent',
            'value' => 'tx_hiotypo3connector_domain_model_patent',
            'icon' => 'tx-hio_typo3_connector-list-of-patents',
        ]
    );
    ExtensionManagementUtility::addTcaSelectItem(
        'sys_reaction',
        'table_name',
        [
            'label' => 'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:tx_hiotypo3connector_domain_model_doctorate',
            'value' => 'tx_hiotypo3connector_domain_model_doctorate',
            'icon' => 'tx-hio_typo3_connector-list-of-doctorates',
        ]
    );
    ExtensionManagementUtility::addTcaSelectItem(
        'sys_reaction',
        'table_name',
        [
            'label' => 'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:tx_hiotypo3connector_domain_model_habilitation',
            'value' => 'tx_hiotypo3connector_domain_model_habilitation',
            'icon' => 'tx-hio_typo3_connector-list-of-habilitations',
        ]
    );
}
