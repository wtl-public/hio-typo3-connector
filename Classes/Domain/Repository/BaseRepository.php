<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\OrInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Wtl\HioTypo3Connector\DataHandling\SlugHelperFactory;
use Wtl\HioTypo3Connector\Domain\Dto\Filter\FilterDto;
use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use Wtl\HioTypo3Connector\Search\UmlautSearchVariantBuilder;

class BaseRepository extends Repository
{
    protected UmlautSearchVariantBuilder $umlautSearchVariantBuilder;
  
    protected SlugHelperFactory $slugHelperFactory;

    public function injectSlugHelperFactory(SlugHelperFactory $factory): void
    {
        $this->slugHelperFactory = $factory;
    }

    public function injectUmlautSearchVariantBuilder(UmlautSearchVariantBuilder $builder): void
    {
        $this->umlautSearchVariantBuilder = $builder;
    }
  
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
            $query->matching($this->getSearchTermQuery($query, $filter->getSearchTerm()));
        }
        if ($ordering) {
            $query->setOrderings($ordering);
        }

        return $query->execute();
    }

    protected function getSearchTermQuery(QueryInterface $query, string $searchTerm): OrInterface
    {
        $variants = $this->umlautSearchVariantBuilder->buildVariants($searchTerm);

        $constraints = array_map(
            fn($v) => $query->like('searchIndex', '%' . $v . '%'),
            $variants
        );

        return $query->logicalOr(...$constraints);
    }

    /**
     * Generates a unique slug for the given record data using the TCA slug config.
     * Pass uid=0 for new records, the actual uid for updates.
     */
    protected function generateSlug(string $table, string $field, array $recordData, int $pid, int $uid = 0): string
    {
        $slugHelper = $this->slugHelperFactory->create($table, $field);
        $value = $slugHelper->generate(array_merge($recordData, ['pid' => $pid]), $pid);

        $state = RecordStateFactory::forName($table)
            ->fromArray(array_merge($recordData, ['uid' => $uid, 'pid' => $pid]), $pid, $uid);

        $tcaFieldConf = $GLOBALS['TCA'][$table]['columns'][$field]['config'];
        
        $evalCodesArray = GeneralUtility::trimExplode(',', $tcaFieldConf['eval'], true);
        if (in_array('unique', $evalCodesArray, true)) {
            $value = $slugHelper->buildSlugForUniqueInTable($value, $state);
        }
        if (in_array('uniqueInSite', $evalCodesArray, true)) {
            $value = $slugHelper->buildSlugForUniqueInSite($value, $state);
        }
        if (in_array('uniqueInPid', $evalCodesArray, true)) {
            $value = $slugHelper->buildSlugForUniqueInPid($value, $state);
        }

        return $value;

    }
}
