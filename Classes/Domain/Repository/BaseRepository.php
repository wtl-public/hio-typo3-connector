<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Generic\Qom\OrInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
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
            $query->matching(
                $this->getSearchTermQuery($query, $filter->getSearchTerm())
            );
        }
        if ($ordering) {
            $query->setOrderings($ordering);
        }

        return $query->execute();
    }
    
    protected function getSearchTermQuery(QueryInterface $query, string $searchTerm): OrInterface
    {
        $term = trim(mb_strtolower($searchTerm));
        
        return  $query->logicalOr(
            $query->like('searchIndex', '%' . $term . '%'),
        );
    }
}
