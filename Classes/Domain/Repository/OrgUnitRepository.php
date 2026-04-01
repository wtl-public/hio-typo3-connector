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
            ['uid'],
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
            $connection->insert(self::TABLE, array_merge($data, [
                'pid'     => $storagePageId,
                'hidden'  => 0,
                'deleted' => 0,
            ]));
        } else {
            $connection->update(self::TABLE, $data, ['uid' => $existing['uid']]);
        }
    }

    public function findByObjectId(int $objectId): ?OrgUnit
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }
}
