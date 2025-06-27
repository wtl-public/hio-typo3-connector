<?php
declare(strict_types=1);

use Doctrine\DBAL\Types\Types;

if (! defined('TYPO3')) {
    die('Access denied.');
}

$lllPrefix = 'LLL:EXT:hio_typo3_connector/Resources/Private/Language/locallang.xlf:';

return [
    'ctrl' => [
        'title' => $lllPrefix . 'tx_hiotypo3connector_domain_model_person',
        'label' => 'name',
        'hideAtCopy' => true,
        'hideTable' => false,
        'default_sortby' => 'name ASC',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'uid,object_id,name,details',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
        'iconfile' => 'EXT:hio_typo3_connector/Resources/Public/Icons/person.svg',
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
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_project.object_id',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 255,
                'eval' => 'trim',
                'readOnly' => true,
                'required' => true,
            ],
        ],
        'name' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_project.name',
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
        'publications' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_person.publications',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_publication',
                'MM' => 'tx_hiotypo3connector_person_publication_mm',
            ],
        ],
        'projects' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_person.projects',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_project',
                'MM' => 'tx_hiotypo3connector_person_project_mm',
            ],
        ],
        'patents' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_person.patents',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_patent',
                'MM' => 'tx_hiotypo3connector_person_patent_mm',
            ],
        ],
        'doctoral_programs' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_person.doctoralPrograms',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_doctoralprogram',
                'MM' => 'tx_hiotypo3connector_person_doctoralprogram_mm',
            ],
        ],
        'habilitations' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_person.habilitations',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_habilitation',
                'MM' => 'tx_hiotypo3connector_person_habilitation_mm',
            ],
        ],
        'org_units' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_person.orgunits',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_orgunit',
                'MM' => 'tx_hiotypo3connector_person_orgunit_mm',
            ],
        ]
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
            'showitem' => 'object_id,  --linebreak--, publications, --linebreak--, projects, --linebreak--',
        ],
        'palette_system' => [
            'showitem' => 'hidden',
        ],
    ],
];
