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
        'PatentList',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePatents',
    );

    ExtensionUtilityAlias::registerPlugin(
    // extension name, matching the PHP namespaces (but without the vendor)
        'HioTypo3Connector',
        // arbitrary, but unique plugin name (not visible in the backend)
        'DoctorateList',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titleDoctorates',
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
    ExtensionUtilityAlias::registerPlugin(
    // extension name, matching the PHP namespaces (but without the vendor)
        'HioTypo3Connector',
        // arbitrary, but unique plugin name (not visible in the backend)
        'PersonSelectedPatentList',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePersonPatents',
    );
    ExtensionUtilityAlias::registerPlugin(
    // extension name, matching the PHP namespaces (but without the vendor)
        'HioTypo3Connector',
        // arbitrary, but unique plugin name (not visible in the backend)
        'PersonSelectedDoctorateList',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePersonDoctorates',
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
    // Configuration/TCA/Overrides/tt_content.php
    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonPatentList.xml',
        'hiotypo3connector_personselectedpatentlist'
    );
    // Configuration/TCA/Overrides/tt_content.php
    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonDoctorateList.xml',
        'hiotypo3connector_personselecteddoctoratelist'
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
    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_personselectedpatentlist']['showitem'];
    $showItem = str_replace(
        '--palette--;;headers,',
        '
            --palette--;;headers,
            pi_flexform,
        ',
        (string)$showItem
    );
    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_personselecteddoctoratelist']['showitem'];
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
    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_patentlist']['showitem'];
    $showItem = str_replace(
        '--palette--;;headers,',
        '
            --palette--;;headers,
            pages,
        ',
        (string)$showItem
    );
    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_doctoratelist']['showitem'];
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
