<?php

$EM_CONF["hio_typo3_connector"] = [
    'title' => 'hio-typo3-connector',
    'description' => 'TYPO3 Connector for HISinOne',
    'version' => '0.7.41',
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
