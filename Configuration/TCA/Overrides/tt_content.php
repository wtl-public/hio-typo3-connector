<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

(static function (): void {

    ExtensionUtility::registerPlugin(
        'HioTypo3Connector',
        'PublicationList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePublications',
    );
    ExtensionUtility::registerPlugin(
        'HioTypo3Connector',
        'ProjectList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titleProjects',
    );
    ExtensionUtility::registerPlugin(
        'HioTypo3Connector',
        'PersonList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePersons',
    );
    ExtensionUtility::registerPlugin(
        'HioTypo3Connector',
        'PatentList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePatents',
    );
    ExtensionUtility::registerPlugin(
        'HioTypo3Connector',
        'DoctorateList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titleDoctorates',
    );
    ExtensionUtility::registerPlugin(
        'HioTypo3Connector',
        'HabilitationList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titleHabilitations',
    );


    ExtensionUtility::registerPlugin(
        'HioTypo3Connector',
        'SelectedPersonPublicationList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonPublications',
    );
    ExtensionUtility::registerPlugin(
        'HioTypo3Connector',
        'SelectedPersonProjectList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonProjects',
    );
    ExtensionUtility::registerPlugin(
        'HioTypo3Connector',
        'SelectedPersonPatentList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonPatents',
    );
    ExtensionUtility::registerPlugin(
        'HioTypo3Connector',
        'SelectedPersonDoctorateList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonDoctorates',
    );
    ExtensionUtility::registerPlugin(
        'HioTypo3Connector',
        'SelectedPersonHabilitationList',
        'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonHabilitations',
    );


    // Configuration/TCA/Overrides/tt_content.php
    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonPublicationList.xml',
        'hiotypo3connector_selectedpersonpublicationlist'
    );
    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonProjectList.xml',
        'hiotypo3connector_selectedpersonprojectlist'
    );
    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonPatentList.xml',
        'hiotypo3connector_selectedpersonpatentlist'
    );
    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonDoctorateList.xml',
        'hiotypo3connector_selectedpersondoctoratelist'
    );
    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonHabilitationList.xml',
        'hiotypo3connector_selectedpersonhabilitationlist'
    );


    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_selectedpersonpublicationlist']['showitem'];
    $showItem = str_replace(
        '--palette--;;headers,',
        '
            --palette--;;headers,
            pi_flexform,
        ',
        (string)$showItem
    );
    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_selectedpersonprojectlist']['showitem'];
    $showItem = str_replace(
        '--palette--;;headers,',
        '
            --palette--;;headers,
            pi_flexform,
        ',
        (string)$showItem
    );
    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_selectedpersonpatentlist']['showitem'];
    $showItem = str_replace(
        '--palette--;;headers,',
        '
            --palette--;;headers,
            pi_flexform,
        ',
        (string)$showItem
    );
    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_selectedpersondoctoratelist']['showitem'];
    $showItem = str_replace(
        '--palette--;;headers,',
        '
            --palette--;;headers,
            pi_flexform,
        ',
        (string)$showItem
    );
    $showItem = &$GLOBALS['TCA']['tt_content']['types']['hiotypo3connector_selectedpersonhabilitationlist']['showitem'];
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
