<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnitDto;
use Wtl\HioTypo3Connector\Domain\Model\OrgUnit;

class OrgUnitRepository extends BaseRepository
{
    private const TABLE = 'tx_hiotypo3connector_domain_model_orgunit';
    
    public function save(OrgUnitDto $orgUnitDto, $storagePageId): void
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TABLE);

        $existing = $connection->select(
            ['uid', 'slug'],
            self::TABLE,
            ['object_id' => $orgUnitDto->getObjectId(), 'deleted' => 0]
        )->fetchAssociative();

        $data = [
            'object_id'    => $orgUnitDto->getObjectId(),
            'title'        => (string)$orgUnitDto->getTitle(),
            'details'      => json_encode($orgUnitDto->getDetails(), JSON_UNESCAPED_UNICODE),
            'search_index' => (string)$orgUnitDto->getSearchIndex(),
        ];

        if ($existing === false) {
            $data['slug'] = $this->generateSlug(self::TABLE, 'slug', $data, $storagePageId);
            $connection->insert(self::TABLE, array_merge($data, [
                'pid'     => $storagePageId,
                'hidden'  => 0,
                'deleted' => 0,
            ]));
        } else {
            // Generate slug if missing (e.g. records imported before slug field existed)
            if (empty($existing['slug'])) {
                $data['slug'] = $this->generateSlug(self::TABLE, 'slug', $data, $storagePageId, $existing['uid']);
            }
            $connection->update(self::TABLE, $data, ['uid' => $existing['uid']]);
        }
    }

    public function findByObjectId(int $objectId): ?OrgUnit
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }

    /**
     * @param int[] $objectIds
     */
    public function findByObjectIds(array $objectIds): array
    {
        if (empty($objectIds)) {
            return [];
        }
        $query = $this->createQuery();
        $query->matching($query->in('objectId', $objectIds));
        return $query->execute()->toArray();
    }
}
