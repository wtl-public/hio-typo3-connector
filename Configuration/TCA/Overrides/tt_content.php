<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility as ExtensionUtilityAlias;

defined('TYPO3') or die();

(static function (): void {

    ExtensionUtilityAlias::registerPlugin(
        'HioTypo3Connector',
        'PublicationList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePublications',
    );
    ExtensionUtilityAlias::registerPlugin(
        'HioTypo3Connector',
        'PublicationDetails',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePublicationDetails',
    );

    ExtensionUtilityAlias::registerPlugin(
        'HioTypo3Connector',
        'ProjectList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titleProjects',
    );

    ExtensionUtilityAlias::registerPlugin(
        'HioTypo3Connector',
        'PersonList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePersons',
    );

    ExtensionUtilityAlias::registerPlugin(
        'HioTypo3Connector',
        'PatentList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePatents',
    );

    ExtensionUtilityAlias::registerPlugin(
        'HioTypo3Connector',
        'DoctorateList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titleDoctorates',
    );

    ExtensionUtilityAlias::registerPlugin(
        'HioTypo3Connector',
        'HabilitationList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titleHabilitations',
    );



    ExtensionUtilityAlias::registerPlugin(
        'HioTypo3Connector',
        'PersonSelectedPublicationList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePersonPublications',
    );
    ExtensionUtilityAlias::registerPlugin(
        'HioTypo3Connector',
        'PersonSelectedProjectList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePersonProjects',
    );
    ExtensionUtilityAlias::registerPlugin(
        'HioTypo3Connector',
        'PersonSelectedPatentList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePersonPatents',
    );
    ExtensionUtilityAlias::registerPlugin(
        'HioTypo3Connector',
        'PersonSelectedDoctorateList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePersonDoctorates',
    );
    ExtensionUtilityAlias::registerPlugin(
        'HioTypo3Connector',
        'PersonSelectedHabilitationList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePersonHabilitations',
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
    // Configuration/TCA/Overrides/tt_content.php
    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonHabilitationList.xml',
        'hiotypo3connector_personselectedhabilitationlist'
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
    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_personselectedhabilitationlist']['showitem'];
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
    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_habilitationlist']['showitem'];
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
