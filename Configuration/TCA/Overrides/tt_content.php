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
    'Nominationlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/nomination.xlf:titleNominations',
    'tx-hio_typo3_connector-list-of-nominations',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Patentlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePatents',
    'tx-hio_typo3_connector-list-of-patents',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Doctoralprogramlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/doctoralProgram.xlf:titleDoctoralPrograms',
    'tx-hio_typo3_connector-list-of-doctoral-programs',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Habilitationlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/habilitation.xlf:titleHabilitations',
    'tx-hio_typo3_connector-list-of-habilitations',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Orgunitlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/orgUnit.xlf:titleOrgUnits',
    'tx-hio_typo3_connector-list-of-org-units',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Researchinfrastructurelist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/researchInfrastructure.xlf:titleResearchInfrastructures',
    'tx-hio_typo3_connector-list-of-research-infrastructures',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Spinofflist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/spinOff.xlf:titleSpinOffs',
    'tx-hio_typo3_connector-list-of-spin-offs',
);


ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Selectedpersonhabilitationlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonHabilitations',
    'tx-hio_typo3_connector-habilitations',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Selectedpersonpatentlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonPatents',
    'tx-hio_typo3_connector-patents',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Selectedpersonorgunitlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonOrgUnits',
    'tx-hio_typo3_connector-org-units',
);

ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Selectedpersondoctoralprogramlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonDoctoralPrograms',
    'tx-hio_typo3_connector-doctoral-programs',
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

ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'SelectedOrgUnitPersonList',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedOrgUnit.xlf:titleOrgUnitPersons',
    'tx-hio_typo3_connector-persons',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'SelectedOrgUnitPublicationList',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedOrgUnit.xlf:titleOrgUnitPublications',
    'tx-hio_typo3_connector-publications',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'SelectedOrgUnitProjectList',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedOrgUnit.xlf:titleOrgUnitProjects',
    'tx-hio_typo3_connector-projects',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'SelectedOrgUnitPatentList',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedOrgUnit.xlf:titleOrgUnitPatents',
    'tx-hio_typo3_connector-patents',
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_selectedpersondoctoralprogramlist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_selectedpersonhabilitationlist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_selectedpersonorgunitlist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_selectedpersonpatentlist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_selectedpersonprojectlist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_selectedpersonpublicationlist'] = 'pi_flexform';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_selectedorgunitpatentlist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_selectedorgunitpersonlist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_selectedorgunitprojectlist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_selectedorgunitpublicationlist'] = 'pi_flexform';

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
    'hiotypo3connector_selectedpersonorgunitlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonOrgUnitList.xml',
);
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_selectedpersondoctoralprogramlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonDoctoralProgramList.xml',
);
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_selectedpersonhabilitationlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonHabilitationList.xml',
);


ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_selectedorgunitpublicationlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedOrgUnitPublicationList.xml',
);
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_selectedorgunitprojectlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedOrgUnitProjectList.xml',
);
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_selectedorgunitpatentlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedOrgUnitPatentList.xml',
);
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_selectedorgunitpersonlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedOrgUnitPersonList.xml',
);


$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_publicationlist'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_publicationlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/PublicationList.xml',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_personlist'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_personlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/PersonList.xml',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_nominationlist'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_nominationlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/NominationList.xml',
);


ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'ProjectHighlights',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/projectHighlights.xlf:flexform.plugin.title',
    'tx-hio_typo3_connector-project-highlights',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_projecthighlights'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_projecthighlights',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/ProjectHighlights.xml',
);

ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'PublicationHighlights',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/publicationHighlights.xlf:flexform.plugin.title',
    'tx-hio_typo3_connector-publication-highlights',
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['hiotypo3connector_publicationhighlights'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    'hiotypo3connector_publicationhighlights',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/PublicationHighlights.xml',
);
