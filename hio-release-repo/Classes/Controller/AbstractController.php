<?php

namespace Wtl\HioTypo3Connector\Controller;

use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

abstract class AbstractController extends ActionController
{
    /**
     * helper function to use localized strings in hio_typo3_connector controllers
     */
    protected function translate(
        string $key,
        string $defaultMessage = ''
    ): string {
        $message = LocalizationUtility::translate($key, 'hio_typo3_connector');
        if ($message === null) {
            $message = $defaultMessage;
        }
        return $message;
    }
}
