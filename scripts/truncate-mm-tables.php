<?php

/**
 * Truncates all HIO MM tables to give a clean slate for benchmarking
 * a first-time import.
 *
 * Run via: ddev composer db:truncate-mm
 *      or: ddev exec php vendor/wtl/hio-typo3-connector/scripts/truncate-mm-tables.php
 */

$p = new PDO(
    'mysql:host=' . (getenv('DATABASE_HOST') ?: 'db') . ';dbname=' . (getenv('DATABASE_NAME') ?: 'db'),
    getenv('DATABASE_USER') ?: 'db',
    getenv('DATABASE_PASSWORD') ?: 'db'
);

$mmTables = [
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
foreach ($mmTables as $table) {
    $p->exec("TRUNCATE TABLE `$table`");
    echo "Truncated: $table\n";
}
$p->exec('SET FOREIGN_KEY_CHECKS = 1');

echo "\nDone — all MM tables cleared. Ready for a clean first-import benchmark.\n";

