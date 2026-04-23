<?php

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

$typo3MajorVersion = (new Typo3Version())->getMajorVersion();

$groupLabel = 'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:plugin.group.hio_publisher';

if ($typo3MajorVersion < 14) {
    // TYPO3 v12/v13: Plugins as list_types
    ExtensionManagementUtility::addTcaSelectItemGroup(
        'tt_content',
        'list_type',
        'hio-publisher',
        $groupLabel
    );
}

ExtensionManagementUtility::addTcaSelectItemGroup(
    'tt_content',
    'CType',
    'hio-publisher',    
    $groupLabel
);

$registerFlexForm = static function ($pluginSignature, $flexForm, bool $hasListTypeFallback = false) use ($typo3MajorVersion): void {
    if ($typo3MajorVersion < 14) {
        // TYPO3 v12/v13: flexform for ctype plugins
        $GLOBALS['TCA']['tt_content']['columns']['pi_flexform']['config']['ds'][',' . $pluginSignature] = $flexForm;

        if ($hasListTypeFallback) {
            // add flex form for legacy list_types
            $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
            ExtensionManagementUtility::addPiFlexFormValue(
                $pluginSignature,
                $flexForm
            );
        }
    } else {
        // TYPO3 v14+: flexform for ctypes
        $GLOBALS['TCA']['tt_content']['types'][$pluginSignature]['columnsOverrides']['pi_flexform']['config']['ds'] = $flexForm;
    }

    ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin, pi_flexform, pages, recursive',
        $pluginSignature,
        'after:palette:headers'
    );
};

ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Publicationlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePublications',
    'tx-hio_typo3_connector-list-of-publications',
    'hio-publisher',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Projectlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titleProjects',
    'tx-hio_typo3_connector-list-of-projects',
    'hio-publisher',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Personlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePersons',
    'tx-hio_typo3_connector-list-of-persons',
    'hio-publisher',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Nominationlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/nomination.xlf:titleNominations',
    'tx-hio_typo3_connector-list-of-nominations',
    'hio-publisher',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Patentlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:titlePatents',
    'tx-hio_typo3_connector-list-of-patents',
    'hio-publisher',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Doctoralprogramlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/doctoralProgram.xlf:titleDoctoralPrograms',
    'tx-hio_typo3_connector-list-of-doctoral-programs',
    'hio-publisher',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Habilitationlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/habilitation.xlf:titleHabilitations',
    'tx-hio_typo3_connector-list-of-habilitations',
    'hio-publisher',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Orgunitlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/orgUnit.xlf:titleOrgUnits',
    'tx-hio_typo3_connector-list-of-org-units',
    'hio-publisher',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Researchinfrastructurelist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/researchInfrastructure.xlf:titleResearchInfrastructures',
    'tx-hio_typo3_connector-list-of-research-infrastructures',
    'hio-publisher',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Spinofflist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/spinOff.xlf:titleSpinOffs',
    'tx-hio_typo3_connector-list-of-spin-offs',
    'hio-publisher',
);


ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Selectedpersonhabilitationlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonHabilitations',
    'tx-hio_typo3_connector-habilitations',
    'hio-publisher',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Selectedpersonpatentlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonPatents',
    'tx-hio_typo3_connector-patents',
    'hio-publisher',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Selectedpersonorgunitlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonOrgUnits',
    'tx-hio_typo3_connector-org-units',
    'hio-publisher',
);

ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Selectedpersondoctoralprogramlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonDoctoralPrograms',
    'tx-hio_typo3_connector-doctoral-programs',
    'hio-publisher',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Selectedpersonprojectlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonProjects',
    'tx-hio_typo3_connector-projects',
    'hio-publisher',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'Selectedpersonpublicationlist',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedPerson.xlf:titlePersonPublications',
    'tx-hio_typo3_connector-publications',
    'hio-publisher',
);

ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'SelectedOrgUnitPersonList',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedOrgUnit.xlf:titleOrgUnitPersons',
    'tx-hio_typo3_connector-persons',
    'hio-publisher',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'SelectedOrgUnitPublicationList',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedOrgUnit.xlf:titleOrgUnitPublications',
    'tx-hio_typo3_connector-publications',
    'hio-publisher',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'SelectedOrgUnitProjectList',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedOrgUnit.xlf:titleOrgUnitProjects',
    'tx-hio_typo3_connector-projects',
    'hio-publisher',
);
ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'SelectedOrgUnitPatentList',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/selectedOrgUnit.xlf:titleOrgUnitPatents',
    'tx-hio_typo3_connector-patents',
    'hio-publisher',
);

$registerFlexForm(
    'hiotypo3connector_selectedpersonpublicationlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonPublicationList.xml',
    true
);
$registerFlexForm(
    'hiotypo3connector_selectedpersonprojectlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonProjectList.xml',
    true
);
$registerFlexForm(
    'hiotypo3connector_selectedpersonpatentlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonPatentList.xml',
    true
);
$registerFlexForm(
    'hiotypo3connector_selectedpersonorgunitlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonOrgUnitList.xml',
    true
);
$registerFlexForm(
    'hiotypo3connector_selectedpersondoctoralprogramlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonDoctoralProgramList.xml',
    true
);
$registerFlexForm(
    'hiotypo3connector_selectedpersonhabilitationlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedPersonHabilitationList.xml',
    true
);

$registerFlexForm(
    'hiotypo3connector_selectedorgunitpublicationlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedOrgUnitPublicationList.xml',
    true
);
$registerFlexForm(
    'hiotypo3connector_selectedorgunitprojectlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedOrgUnitProjectList.xml',
    true
);
$registerFlexForm(
    'hiotypo3connector_selectedorgunitpatentlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedOrgUnitPatentList.xml',
    true
);
$registerFlexForm(
    'hiotypo3connector_selectedorgunitpersonlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/SelectedOrgUnitPersonList.xml',
    true
);

$registerFlexForm(
    'hiotypo3connector_publicationlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/PublicationList.xml',
    true
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin, pages, recursive',
    'hiotypo3connector_projectlist',
    'after:palette:headers'
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin, pages, recursive',
    'hiotypo3connector_orgunitlist',
    'after:palette:headers'
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin, pages, recursive',
    'hiotypo3connector_spinofflist',
    'after:palette:headers'
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin, pages, recursive',
    'hiotypo3connector_researchinfrastructurelist',
    'after:palette:headers'
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin, pages, recursive',
    'hiotypo3connector_doctoralprogramlist',
    'after:palette:headers'
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin, pages, recursive',
    'hiotypo3connector_habilitationlist',
    'after:palette:headers'
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin, pages, recursive',
    'hiotypo3connector_patentlist',
    'after:palette:headers'
);
$registerFlexForm(
    'hiotypo3connector_personlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/PersonList.xml',
    true
);
$registerFlexForm(
    'hiotypo3connector_nominationlist',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/NominationList.xml',
    true
);

ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'ProjectHighlights',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/projectHighlights.xlf:flexform.plugin.title',
    'tx-hio_typo3_connector-project-highlights',
    'hio-publisher',
);
$registerFlexForm(
    'hiotypo3connector_projecthighlights',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/ProjectHighlights.xml',
    true
);

ExtensionUtility::registerPlugin(
    'HioTypo3Connector',
    'PublicationHighlights',
    'LLL:EXT:hio_typo3_connector/Resources/Private/Language/publicationHighlights.xlf:flexform.plugin.title',
    'tx-hio_typo3_connector-publication-highlights',
    'hio-publisher',
);
$registerFlexForm(
    'hiotypo3connector_publicationhighlights',
    'FILE:EXT:hio_typo3_connector/Configuration/FlexForm/PublicationHighlights.xml',
    true
);
