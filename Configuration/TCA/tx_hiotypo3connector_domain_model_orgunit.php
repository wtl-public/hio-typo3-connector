<?php
declare(strict_types=1);

use Doctrine\DBAL\Types\Types;

if (! defined('TYPO3')) {
    die('Access denied.');
}

$lllPrefix = 'LLL:EXT:hio_typo3_connector/Resources/Private/Language/orgUnit.xlf:';

return [
    'ctrl' => [
        'title' => $lllPrefix . 'tx_hiotypo3connector_domain_model_orgunit',
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
        'iconfile' => 'EXT:hio_typo3_connector/Resources/Public/Icons/orgUnit.svg',
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
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_orgunit.object_id',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 255,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'title' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_orgunit.title',
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
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_orgunit.publications',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_publication',
                'MM' => 'tx_hiotypo3connector_orgunit_publication_mm',
            ],
        ],
        'projects' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_orgunit.projects',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_project',
                'MM' => 'tx_hiotypo3connector_orgunit_project_mm',
            ],
        ],
        'patents' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_orgunit.patents',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_patent',
                'MM' => 'tx_hiotypo3connector_orgunit_patent_mm',
            ],
        ],
        'doctoral_programs' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_orgunit.doctoralPrograms',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_doctoralprogram',
                'MM' => 'tx_hiotypo3connector_orgunit_doctoralprogram_mm',
            ],
        ],
        'habilitations' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_orgunit.habilitations',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_habilitation',
                'MM' => 'tx_hiotypo3connector_orgunit_habilitation_mm',
            ],
        ],
        'research_infrastructures' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_orgunit.researchInfrastructures',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_researchinfrastructure',
                'MM' => 'tx_hiotypo3connector_orgunit_researchinfrastructure_mm',
            ],
        ],
        'spin_offs' => [
            'label' => $lllPrefix . 'tx_hiotypo3connector_domain_model_orgunit.spinOffs',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_hiotypo3connector_domain_model_spinoff',
                'MM' => 'tx_hiotypo3connector_orgunit_spinoff_mm',
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
