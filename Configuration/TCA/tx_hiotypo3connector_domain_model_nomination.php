<?php
declare(strict_types=1);

use Doctrine\DBAL\Types\Types;

if (! defined('TYPO3')) {
    die('Access denied.');
}

$lllPrefix = 'LLL:EXT:hio_typo3_connector/Resources/Private/Language/nomination.xlf:';

return [
    'ctrl' => [
        'title' => $lllPrefix . 'tx_hiotypo3connector_domain_model_nomination',
        'label' => 'title',
        'hideAtCopy' => true,
        'hideTable' => false,
        'default_sortby' => 'title ASC',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'uid,object_id,title,details',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
        'iconfile' => 'EXT:hio_typo3_connector/Resources/Public/Icons/nomination.svg',
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
        'nomination_year' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_nomination.nomination_year',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 4,
                'eval' => 'trim',
                'readOnly' => true,
                'required' => false,
            ],
        ],
        'object_id' => [
            'exclude' => true,
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_nomination.object_id',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 255,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'scope' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_nomination.scope',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 255,
                'eval' => 'trim',
                'readOnly' => true,
                'required' => false,
            ],
        ],
        'status' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_nomination.status',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 255,
                'eval' => 'trim',
                'readOnly' => true,
                'required' => false,
            ],
        ],
        'title' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_nomination.title',
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
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_nomination.type',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 255,
                'eval' => 'trim',
                'readOnly' => true,
                'required' => false,
            ],
        ],
        'visibility' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_nomination.visibility',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 255,
                'eval' => 'trim',
                'readOnly' => true,
                'required' => false,
            ],
        ],
        'details' => [
            'label' => 'details',
            'config' => [
                'type' => Types::JSON,
                'notnull' => false,
            ],
        ],
        'search_index' => [
            'label' => 'Search Index',
            'config' => [
                'type' => Types::JSON,
                'notnull' => false,
            ],
        ],
        'org_units' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_nomination.orgUnits',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_orgunit',
                'MM' => 'tx_hiotypo3connector_nomination_orgunit_mm',
            ],
        ],
        'publications' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_nomination.publications',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_publication',
                'MM' => 'tx_hiotypo3connector_nomination_publication_mm',
            ],
        ],
        'projects' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_nomination.projects',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_project',
                'MM' => 'tx_hiotypo3connector_nomination_project_mm',
            ],
        ],
        'nominees' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_nomination.nominees',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_person',
                'MM' => 'tx_hiotypo3connector_nomination_person_mm',
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
