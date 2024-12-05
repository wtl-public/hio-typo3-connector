<?php
declare(strict_types=1);


use Doctrine\DBAL\Types\Types;

if (! defined('TYPO3')) {
    die('Access denied.');
}

$lllPrefix = 'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:';

return [
    'ctrl' => [
        'title' => $lllPrefix . 'tx_hiotypo3connector_domain_model_publication',
        'label' => 'title',
        'hideAtCopy' => true,
        'hideTable' => false,
        'default_sortby' => 'type ASC',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'uid,object_id,title,type,details',
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
                        'object_id', // add additional fields
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
        'object_id' => [
            'exclude' => true,
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_publication.object_id',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 255,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'title' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_publication.title',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 255,
                'eval' => 'trim',
                'readOnly' => true,
                'required' => false,
            ],
        ],
        'type' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_publication.type',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 255,
                'eval' => 'trim',
                'readOnly' => true,
                'required' => false,
            ],
        ],
        'release_year' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_publication.release_year',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 4,
                'eval' => 'trim',
                'readOnly' => true,
                'required' => false,
            ],
        ],
        'details' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_publication.details',
            'config' => [
                'type' => Types::BLOB,
                'notnull' => false,
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
            'showitem' => 'type, object_id, --linebreak--',
        ],
        'palette_system' => [
            'showitem' => 'hidden',
        ],
    ],
];
