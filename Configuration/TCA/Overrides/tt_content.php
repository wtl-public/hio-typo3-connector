<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility as ExtensionUtilityAlias;

defined('TYPO3') or die();

(static function (): void {
    ExtensionUtilityAlias::registerPlugin(
    // extension name, matching the PHP namespaces (but without the vendor)
        'HioTypo3Connector',
        // arbitrary, but unique plugin name (not visible in the backend)
        'PublicationList',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePublications',
    );
    ExtensionUtilityAlias::registerPlugin(
    // extension name, matching the PHP namespaces (but without the vendor)
        'HioTypo3Connector',
        // arbitrary, but unique plugin name (not visible in the backend)
        'PublicationDetails',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePublicationDetails',
    );

    ExtensionUtilityAlias::registerPlugin(
    // extension name, matching the PHP namespaces (but without the vendor)
        'HioTypo3Connector',
        // arbitrary, but unique plugin name (not visible in the backend)
        'ProjectList',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titleProjects',
    );

    ExtensionUtilityAlias::registerPlugin(
    // extension name, matching the PHP namespaces (but without the vendor)
        'HioTypo3Connector',
        // arbitrary, but unique plugin name (not visible in the backend)
        'PersonList',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePersons',
    );

    ExtensionUtilityAlias::registerPlugin(
    // extension name, matching the PHP namespaces (but without the vendor)
        'HioTypo3Connector',
        // arbitrary, but unique plugin name (not visible in the backend)
        'PersonSelectedPublicationList',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePersonPublications',
    );
    ExtensionUtilityAlias::registerPlugin(
    // extension name, matching the PHP namespaces (but without the vendor)
        'HioTypo3Connector',
        // arbitrary, but unique plugin name (not visible in the backend)
        'PersonSelectedProjectList',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePersonProjects',
    );

    // Configuration/TCA/Overrides/tt_content.php
    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonPublicationList.xml',
        'hiotypo3connector_personselectedpublicationlist'
    );
    // Configuration/TCA/Overrides/tt_content.php
    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonProjectList.xml',
        'hiotypo3connector_personselectedprojectlist'
    );

    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_personselectedpublicationlist']['showitem'];
    $showItem = str_replace(
        '--palette--;;headers,',
        '
            --palette--;;headers,
            pi_flexform,
        ',
        (string)$showItem
    );
    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_personselectedprojectlist']['showitem'];
    $showItem = str_replace(
        '--palette--;;headers,',
        '
            --palette--;;headers,
            pi_flexform,
        ',
        (string)$showItem
    );

    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_publicationlist']['showitem'];
    $showItem = str_replace(
        '--palette--;;headers,',
        '
            --palette--;;headers,
            pages,
        ',
        (string)$showItem
    );
    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_publicationdetails']['showitem'];
    $showItem = str_replace(
        '--palette--;;headers,',
        '
            --palette--;;headers,
            pages,
        ',
        (string)$showItem
    );
    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_projectlist']['showitem'];
    $showItem = str_replace(
        '--palette--;;headers,',
        '
            --palette--;;headers,
            pages,
        ',
        (string)$showItem
    );
    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_personlist']['showitem'];
    $showItem = str_replace(
        '--palette--;;headers,',
        '
            --palette--;;headers,
            pages,
        ',
        (string)$showItem
    );
})();
