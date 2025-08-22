<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Wtl\HioTypo3Connector\Domain\Dto\Filter\FilterDto;

class BaseRepository extends Repository
{
    public function initializeObject(): void
    {
        $querySettings = $this->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    public function findByFilter(FilterDto $filter, ?array $ordering = [])
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        if ($filter->getSearchTerm()) {
            $searchTerm = trim($filter->getSearchTerm());
            $query->matching(
                $query->logicalOr(
                    $query->like('searchIndex', '%' . strtolower($searchTerm) . '%'),
                )
            );
        }
        if ($ordering) {
            $query->setOrderings($ordering);
        }

        return $query->execute();
    }
}
