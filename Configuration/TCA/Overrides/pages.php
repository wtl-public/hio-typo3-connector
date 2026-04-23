<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::registerPageTSConfigFile(
    'hio_typo3_connector',
    'Configuration/TsConfig/Page/Mod/Wizards/HioTypo3Connector.tsconfig',
    'HIO TYPO3 Connector Plugins',
);
