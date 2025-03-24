<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Publicationlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePublications',
    'tx-hio_typo3_connector-list-of-publications',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Projectlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titleProjects',
    'tx-hio_typo3_connector-list-of-projects',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Personlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePersons',
    'tx-hio_typo3_connector-list-of-persons',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Patentlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePatents',
    'tx-hio_typo3_connector-list-of-patents',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Doctoratelist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titleDoctorates',
    'tx-hio_typo3_connector-list-of-doctorates',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Habilitationlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titleHabilitations',
    'tx-hio_typo3_connector-list-of-habilitations',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Selectedpersonhabilitationlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonPublications',
    'tx-hio_typo3_connector-publications',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Selectedpersonpatentlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonPatents',
    'tx-hio_typo3_connector-patents',
);

ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Selectedpersondoctoratelist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonProjects',
    'tx-hio_typo3_connector-projects',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Selectedpersonprojectlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonProjects',
    'tx-hio_typo3_connector-projects',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Selectedpersonpublicationlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonPublications',
    'tx-hio_typo3_connector-publications',
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_selectedpersonpatentlist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_selectedpersonpublicationlist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_selectedpersonprojectlist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_selectedpersondoctoratelist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_selectedpersonhabilitationlist'] = 'pi_flexform';

// Configuration/TCA/Overrides/tt_content.php
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_selectedpersonpublicationlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonPublicationList.xml',
);
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_selectedpersonprojectlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonProjectList.xml',
);
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_selectedpersonpatentlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonPatentList.xml',
);
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_selectedpersondoctoratelist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonDoctorateList.xml',
);
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_selectedpersonhabilitationlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonHabilitationList.xml',
);

