<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wtl\HioTypo3Connector\Domain\Dto\Filter\FilterDto as FilterDto;
use Wtl\HioTypo3Connector\Domain\Dto\Filter\PublicationFilter;
use Wtl\HioTypo3Connector\Domain\Dto\PublicationDto;
use Wtl\HioTypo3Connector\Domain\Model\OrgUnit;
use Wtl\HioTypo3Connector\Domain\Model\Person;
use Wtl\HioTypo3Connector\Domain\Model\Publication;

class PublicationRepository extends BaseRepository
{
    private const TABLE = 'tx_hiotypo3connector_domain_model_publication';

    public function save(PublicationDto $publicationDto, int $storagePid = 0): void
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TABLE);

        $existing = $connection->select(
            ['uid'], self::TABLE,
            ['object_id' => $publicationDto->getObjectId(), 'deleted' => 0]
        )->fetchAssociative();

        $data = [
            'object_id'    => $publicationDto->getObjectId(),
            'title'        => (string)$publicationDto->getTitle(),
            'type'         => (string)$publicationDto->getPublicationType()->getName(),
            'release_year' => $publicationDto->getReleaseYear(),
            'details'      => json_encode($publicationDto->getDetails(), JSON_UNESCAPED_UNICODE),
            'search_index' => (string)$publicationDto->getSearchIndex(),
        ];

        if ($existing === false) {
            $connection->insert(self::TABLE, array_merge($data, [
                'pid' => $storagePid, 'hidden' => 0, 'deleted' => 0,
            ]));
        } else {
            $connection->update(self::TABLE, $data, ['uid' => $existing['uid']]);
        }
    }

    public function findByObjectId(int $objectId): ?Publication
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }

    public function getPublicationsByPerson(Person $person, ?array $ordering = [])
    {
        $publicationIds = [];
        foreach ($person->getPublications() as $publication) {
            $publicationIds[] = $publication->getObjectId();
        }
        if (empty($publicationIds)) {
            return [];
        }

        $query = $this->createQuery();
        $query->setOrderings($ordering);
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->in('objectId', $publicationIds));

        return $query->execute();
    }

    public function getPublicationsByOrgUnit(OrgUnit $orgUnit, ?array $ordering = [])
    {
        $publicationIds = [];
        foreach ($orgUnit->getPublications() as $publication) {
            $publicationIds[] = $publication->getObjectId();
        }
        if (empty($publicationIds)) {
            return [];
        }

        $query = $this->createQuery();
        $query->setOrderings($ordering);
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->in('objectId', $publicationIds));

        return $query->execute();
    }

    public function findByFilter(PublicationFilter|FilterDto $filter, ?array $ordering = [])
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $constraints = [];

        if ($filter->getSearchTerm()) {
            $constraints[] = $this->getSearchTermQuery($query, $filter->getSearchTerm());
        }
        if ($filter->getReleaseYearFrom()) {
            $constraints[] =
                    $query->greaterThanOrEqual('releaseYear', $filter->getReleaseYearFrom());
        }

        if ($filter->getReleaseYearTo()) {
            $constraints[] = $query->lessThanOrEqual('releaseYear', $filter->getReleaseYearTo());

        }
        if ($filter->getType()) {
            $constraints[] =
                $query->equals('type', $filter->getType()
            );
        }

        if (!empty($constraints)) {
            $query->matching($query->logicalAnd(...$constraints));
        }

        // Apply ordering if provided
        if ($ordering) {
            $query->setOrderings($ordering);
        }

        return $query->execute();
    }

    public function getPublications(?array $ordering = [])
    {
        $query = $this->createQuery();
        $query->setOrderings($ordering);
        $query->getQuerySettings()->setRespectStoragePage(false);

        return $query->execute();
    }

    public function countPublicationsByTypeAndPerson(Person $person)
    {
        $publicationIds = [];
        foreach ($person->getPublications() as $publication) {
            $publicationIds[] = $publication->getObjectId();
        }

        if (empty($publicationIds)) {
            return [];
        }

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->statement(
            'SELECT type, COUNT(*) as count FROM tx_hiotypo3connector_domain_model_publication WHERE object_id IN (' . implode(',', $publicationIds) . ') GROUP BY type ORDER BY count DESC'
        );

        return $query->execute(true);
    }

    public function getPublicationTypes()
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->statement(
            'SELECT DISTINCT type FROM tx_hiotypo3connector_domain_model_publication WHERE type IS NOT NULL ORDER BY type'
        );
        return $query->execute(true);
    }
}
