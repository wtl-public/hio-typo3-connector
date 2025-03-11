<?php
declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Wtl\HioTypo3Connector\Controller\PersonController;
use Wtl\HioTypo3Connector\Controller\ProjectController;
use Wtl\HioTypo3Connector\Controller\PublicationController;
use Wtl\HioTypo3Connector\Controller\PatentController;
use Wtl\HioTypo3Connector\Controller\DoctorateController;
use Wtl\HioTypo3Connector\Controller\HabilitationController;


ExtensionUtility::configurePlugin(
// extension name, matching the PHP namespaces (but without the vendor)
    'HioTypo3Connector',
    // arbitrary, but unique plugin name (not visible in the backend)
    'PublicationList',
    // all actions
    [PublicationController::class => 'index, show'],
    pluginType:  ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
// non-cacheable actions
);

ExtensionUtility::configurePlugin(
// extension name, matching the PHP namespaces (but without the vendor)
    'HioTypo3Connector',
    // arbitrary, but unique plugin name (not visible in the backend)
    'PublicationDetails',
    // all actions
    [PublicationController::class => 'show'],
    pluginType:  ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
// non-cacheable actions
);

ExtensionUtility::configurePlugin(
    // extension name, matching the PHP namespaces (but without the vendor)
    'HioTypo3Connector',
    // arbitrary, but unique plugin name (not visible in the backend)
    'ProjectList',
    // all actions
    [ProjectController::class => 'index, show'],
    pluginType:  ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    // non-cacheable actions
);

ExtensionUtility::configurePlugin(
    // extension name, matching the PHP namespaces (but without the vendor)
    'HioTypo3Connector',
    // arbitrary, but unique plugin name (not visible in the backend)
    'PersonList',
    // all actions
    [PersonController::class => 'index, show'],
    pluginType:  ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    // non-cacheable actions
);

ExtensionUtility::configurePlugin(
// extension name, matching the PHP namespaces (but without the vendor)
    'HioTypo3Connector',
    // arbitrary, but unique plugin name (not visible in the backend)
    'PatentList',
    // all actions
    [PatentController::class => 'index, show'],
    pluginType:  ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
// non-cacheable actions
);
ExtensionUtility::configurePlugin(
// extension name, matching the PHP namespaces (but without the vendor)
    'HioTypo3Connector',
    // arbitrary, but unique plugin name (not visible in the backend)
    'DoctorateList',
    // all actions
    [DoctorateController::class => 'index, show'],
    pluginType:  ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
// non-cacheable actions
);
ExtensionUtility::configurePlugin(
// extension name, matching the PHP namespaces (but without the vendor)
    'HioTypo3Connector',
    // arbitrary, but unique plugin name (not visible in the backend)
    'HabilitationList',
    // all actions
    [HabilitationController::class => 'index, show'],
    pluginType:  ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
// non-cacheable actions
);


ExtensionUtility::configurePlugin(
// extension name, matching the PHP namespaces (but without the vendor)
    'HioTypo3Connector',
    // arbitrary, but unique plugin name (not visible in the backend)
    'SelectedPersonPublicationList',
    // all actions
    [PersonController::class => 'publicationList'],
    // non-cacheable actions
    [],
    pluginType:  ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
ExtensionUtility::configurePlugin(
// extension name, matching the PHP namespaces (but without the vendor)
    'HioTypo3Connector',
    // arbitrary, but unique plugin name (not visible in the backend)
    'SelectedPersonProjectList',
    // all actions
    [PersonController::class => 'projectList'],
    pluginType:  ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
// non-cacheable actions
);
ExtensionUtility::configurePlugin(
// extension name, matching the PHP namespaces (but without the vendor)
    'HioTypo3Connector',
    // arbitrary, but unique plugin name (not visible in the backend)
    'SelectedPersonPatentList',
    // all actions
    [PersonController::class => 'patentList'],
    pluginType:  ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
// non-cacheable actions
);
ExtensionUtility::configurePlugin(
// extension name, matching the PHP namespaces (but without the vendor)
    'HioTypo3Connector',
    // arbitrary, but unique plugin name (not visible in the backend)
    'SelectedPersonDoctorateList',
    // all actions
    [PersonController::class => 'doctorateList'],
    pluginType:  ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
// non-cacheable actions
);
ExtensionUtility::configurePlugin(
// extension name, matching the PHP namespaces (but without the vendor)
    'HioTypo3Connector',
    // arbitrary, but unique plugin name (not visible in the backend)
    'SelectedPersonHabilitationList',
    // all actions
    [PersonController::class => 'habilitationList'],
    pluginType:  ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
// non-cacheable actions
);


