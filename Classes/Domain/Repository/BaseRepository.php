<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;

class BaseRepository extends Repository 
{
    public function initializeObject(): void
    {
        $querySettings = $this->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }
}
