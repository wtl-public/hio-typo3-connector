<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wtl\HioTypo3Connector\Domain\Dto\Filter\FilterDto;
use Wtl\HioTypo3Connector\Domain\Dto\NominationDto;
use Wtl\HioTypo3Connector\Domain\Model\Nomination;

class NominationRepository extends BaseRepository
{
    private const TABLE = 'tx_hiotypo3connector_domain_model_nomination';

    public function save(NominationDto $dto, $storagePageId): void
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TABLE);

        $existing = $connection->select(
            ['uid', 'slug'], self::TABLE,
            ['object_id' => $dto->getObjectId(), 'deleted' => 0]
        )->fetchAssociative();

        $data = [
            'object_id'       => $dto->getObjectId(),
            'title'           => (string)$dto->getTitle(),
            'status'          => (string)$dto->getStatus()->getName(),
            'type'            => $dto->getNominationType() ? (string)$dto->getNominationType()->getName() : '',
            'visibility'      => (string)$dto->getVisibility()->getName(),
            'nomination_year' => $dto->getNominationYear(),
            'details'         => json_encode($dto->getDetails(), JSON_UNESCAPED_UNICODE),
            'search_index'    => (string)$dto->getSearchIndex(),
        ];

        if ($existing === false) {
            $data['slug'] = $this->generateSlug(self::TABLE, 'slug', $data, $storagePageId);
            $connection->insert(self::TABLE, array_merge($data, [
                'pid' => $storagePageId, 'hidden' => 0, 'deleted' => 0,
            ]));
        } else {
            // Generate slug if missing (e.g. records imported before slug field existed)
            if (empty($existing['slug'])) {
                $data['slug'] = $this->generateSlug(self::TABLE, 'slug', $data, $storagePageId, $existing['uid']);
            }
            $connection->update(self::TABLE, $data, ['uid' => $existing['uid']]);
        }
    }

    public function findByObjectId(int $objectId): ?Nomination
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }

    public function findByFilter(NominationFilter|FilterDto $filter, ?array $ordering = [])
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $constraints = [];
        if ($filter->getSearchTerm()) {
            $constraints[] = $this->getSearchTermQuery($query, $filter->getSearchTerm());
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
}
