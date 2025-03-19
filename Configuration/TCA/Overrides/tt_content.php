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
    'Publicationdetails',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePublicationDetails',
    'tx-hio_typo3_connector-projects',
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
    'Personselectedhabilitationlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonPublications',
    'tx-hio_typo3_connector-publications',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Personselectedpatentlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonPatents',
    'tx-hio_typo3_connector-patents',
);

ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Personselecteddoctoratelist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonProjects',
    'tx-hio_typo3_connector-projects',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Personselectedprojectlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonProjects',
    'tx-hio_typo3_connector-projects',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Personselectedpublicationlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonPublications',
    'tx-hio_typo3_connector-publications',
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_personselectedpatentlist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_personselectedpublicationlist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_personselectedprojectlist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_personselecteddoctoratelist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_personselectedhabilitationlist'] = 'pi_flexform';

// Configuration/TCA/Overrides/tt_content.php
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_personselectedpublicationlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonPublicationList.xml',
);
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_personselectedprojectlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonProjectList.xml',
);
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_personselectedpatentlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonPatentList.xml',
);
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_personselecteddoctoratelist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonDoctorateList.xml',
);
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_personselectedhabilitationlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonHabilitationList.xml',
);

