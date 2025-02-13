<?php
declare(strict_types=1);

use Doctrine\DBAL\Types\Types;

if (! defined('TYPO3')) {
    die('Access denied.');
}

$lllPrefix = 'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:';

return [
    'ctrl' => [
        'title' => $lllPrefix . 'tx_hiotypo3connector_domain_model_citationstyle',
        'label' => 'label',
        'hideAtCopy' => true,
        'hideTable' => false,
        'default_sortby' => 'label ASC',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'uid,label',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ],
        ],
        'cruser_id' => [
            'label' => 'cruser_id',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'pid' => [
            'label' => 'pid',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'slug' => [
            'label' => 'slug',
            'config' => [
                'type' => 'slug',
                'size' => 50,
                'generatorOptions' => [
                    'fields' => [
                        'label', // add additional fields
                    ],
                    'fieldSeparator' => '/',
                    'prefixParentPageSlug' => true,
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite', //  uniqueInSite, uniqueInPid, unique !!!
                'default' => '',
            ],
        ],
        'sorting' => [
            'label' => 'sorting',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'label' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_citationstyle.label',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 255,
                'eval' => 'trim',
                'readOnly' => true,
                'required' => false,
            ],
        ],
    ],
    'types' => [
        0 => [
            'showitem' =>
                '--div--;' . $lllPrefix . 'tab.keyfact_type,' .
                '--palette--;;palette_general,' .
                '--div--;' . $lllPrefix . 'tab.system,' .
                '--palette--;;palette_system,'
            ,
        ],
    ],
    'palettes' => [
        'palette_general' => [
            'showitem' => 'type, label, --linebreak--',
        ],
        'palette_system' => [
            'showitem' => 'hidden',
        ],
    ],
];
