<?php
declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Wtl\HioTypo3Connector\Controller\PersonController;
use Wtl\HioTypo3Connector\Controller\ProjectController;
use Wtl\HioTypo3Connector\Controller\PublicationController;


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
    'PersonSelectedPublicationList',
    // all actions
    [PersonController::class => 'publicationList'],
    pluginType:  ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
// non-cacheable actions
);
ExtensionUtility::configurePlugin(
// extension name, matching the PHP namespaces (but without the vendor)
    'HioTypo3Connector',
    // arbitrary, but unique plugin name (not visible in the backend)
    'PersonSelectedProjectList',
    // all actions
    [PersonController::class => 'projectList'],
    pluginType:  ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
// non-cacheable actions
);


