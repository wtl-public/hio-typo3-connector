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

// Configuration/TCA/Overrides/tt_content.php
ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonPublicationList.xml',
    'hiotypo3connector_personselectedpublicationlist'
);
ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonProjectList.xml',
    'hiotypo3connector_personselectedprojectlist'
);
ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonPatentList.xml',
    'hiotypo3connector_personselectedpatentlist'
);
ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonDoctorateList.xml',
    'hiotypo3connector_personselecteddoctoratelist'
);
ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonHabilitationList.xml',
    'hiotypo3connector_personselectedhabilitationlist'
);

