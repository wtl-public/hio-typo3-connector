<?php

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') or die();

call_user_func(function () {
    $extensionKey = 'hio_typo3_connector';
    $versionInformation = GeneralUtility::makeInstance(Typo3Version::class);
    if ($versionInformation->getMajorVersion() < 13) {
        ExtensionManagementUtility::addStaticFile(
            $extensionKey,
            'Configuration/TypoScript',
            'HIO TYPO3 Connector',
        );
        ExtensionManagementUtility::addStaticFile(
            $extensionKey,
            'Configuration/TypoScript/Frontend',
            'HIO TYPO3 Connector Tailwind CSS',
        );
    }
});
