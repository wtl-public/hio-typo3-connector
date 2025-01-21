<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'tx-hio_typo3_connector-publication' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:hio_typo3_connector/Resources/Public/Icons/book-svgrepo-com.svg',
    ],
    'tx-hio_typo3_connector-project' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:hio_typo3_connector/Resources/Public/Icons/project-svgrepo-com.svg',
    ],
    'tx-hio_typo3_connector-list' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:hio_typo3_connector/Resources/Public/Icons/list-svgrepo-com.svg',
    ],
];
