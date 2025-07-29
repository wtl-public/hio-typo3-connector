<?php
namespace Wtl\HioTypo3Connector\UserFunc;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use Wtl\HioTypo3Connector\Domain\Repository\CitationStyleRepository;

class FlexFormUserFunc {
    public function getCitationStyles(array &$params, $parentObject) {
        $citationStyles = GeneralUtility::makeInstance(CitationStyleRepository::class)->findAll();

        foreach ($citationStyles as $citationStyle) {
            $labelKey = 'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:' . $citationStyle->getLabel();
            $translatedLabel = LocalizationUtility::translate($labelKey, 'hio_typo3_connector');

            $params['items'][] = [$translatedLabel ?? $citationStyle->getLabel(), $citationStyle->getLabel()];
        }
    }
}