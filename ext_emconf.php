<?php

$EM_CONF["hio_typo3_connector"] = [
    'title' => 'TYPO3 Connector für HISinOne',
    'description' => 'TYPO3 Connector für die Integration von Daten aus HISinOne',
    'version' => '0.9.3',
    'state' => 'stable',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Wtl\\HioTypo3Connector\\' => 'Classes/',
        ],
    ],
];
