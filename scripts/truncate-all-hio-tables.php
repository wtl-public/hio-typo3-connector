<?php

/**
 * Truncates ALL HIO tables (domain models + MM relations) to give a completely
 * clean slate, e.g. before a full re-import from scratch.
 *
 * Run via: ddev composer db:truncate-hio
 *      or: ddev exec php vendor/wtl/hio-typo3-connector/scripts/truncate-all-hio-tables.php
 */

$p = new PDO(
    'mysql:host=' . (getenv('DATABASE_HOST') ?: 'db') . ';dbname=' . (getenv('DATABASE_NAME') ?: 'db'),
    getenv('DATABASE_USER') ?: 'db',
    getenv('DATABASE_PASSWORD') ?: 'db'
);

$tables = [
    // Domain model tables
    'tx_hiotypo3connector_domain_model_citationstyle',
    'tx_hiotypo3connector_domain_model_doctoralprogram',
    'tx_hiotypo3connector_domain_model_habilitation',
    'tx_hiotypo3connector_domain_model_nomination',
    'tx_hiotypo3connector_domain_model_orgunit',
    'tx_hiotypo3connector_domain_model_patent',
    'tx_hiotypo3connector_domain_model_person',
    'tx_hiotypo3connector_domain_model_project',
    'tx_hiotypo3connector_domain_model_publication',
    'tx_hiotypo3connector_domain_model_researchinfrastructure',
    'tx_hiotypo3connector_domain_model_spinoff',
    // MM relation tables
    'tx_hiotypo3connector_person_publication_mm',
    'tx_hiotypo3connector_person_project_mm',
    'tx_hiotypo3connector_person_patent_mm',
    'tx_hiotypo3connector_person_orgunit_mm',
    'tx_hiotypo3connector_person_doctoralprogram_mm',
    'tx_hiotypo3connector_person_habilitation_mm',
    'tx_hiotypo3connector_orgunit_publication_mm',
    'tx_hiotypo3connector_orgunit_project_mm',
    'tx_hiotypo3connector_orgunit_patent_mm',
    'tx_hiotypo3connector_orgunit_person_mm',
    'tx_hiotypo3connector_orgunit_doctoralprogram_mm',
    'tx_hiotypo3connector_orgunit_habilitation_mm',
    'tx_hiotypo3connector_orgunit_researchinfrastructure_mm',
    'tx_hiotypo3connector_orgunit_spinoff_mm',
    'tx_hiotypo3connector_nomination_person_mm',
    'tx_hiotypo3connector_nomination_orgunit_mm',
    'tx_hiotypo3connector_nomination_project_mm',
    'tx_hiotypo3connector_nomination_publication_mm',
];

$p->exec('SET FOREIGN_KEY_CHECKS = 0');
foreach ($tables as $table) {
    $p->exec("TRUNCATE TABLE `$table`");
    echo "Truncated: $table\n";
}
$p->exec('SET FOREIGN_KEY_CHECKS = 1');

echo "\nDone — all HIO tables cleared. Ready for a clean full re-import.\n";

