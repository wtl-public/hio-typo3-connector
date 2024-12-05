<?php

$EM_CONF["hio_typo3_connector"] = [
    'title' => 'hio-typo3-connector',
    'description' => 'TYPO3 Connector for HISinOne',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.0',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Wtl\\HioTypo3Connector\\' => 'Classes/',
        ],
    ],
];
