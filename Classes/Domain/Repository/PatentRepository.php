<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wtl\HioTypo3Connector\Domain\Dto\PatentDto;
use Wtl\HioTypo3Connector\Domain\Model\Patent;

class PatentRepository extends BaseRepository
{
    private const TABLE = 'tx_hiotypo3connector_domain_model_patent';

    public function save(PatentDto $patentDto, $storagePageId): void
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TABLE);

        $existing = $connection->select(
            ['uid'], self::TABLE,
            ['object_id' => $patentDto->getObjectId(), 'deleted' => 0]
        )->fetchAssociative();

        $data = [
            'object_id'    => $patentDto->getObjectId(),
            'title'        => (string)$patentDto->getTitle(),
            'details'      => json_encode($patentDto->getDetails(), JSON_UNESCAPED_UNICODE),
            'search_index' => (string)$patentDto->getSearchIndex(),
        ];

        if ($existing === false) {
            $connection->insert(self::TABLE, array_merge($data, [
                'pid' => $storagePageId, 'hidden' => 0, 'deleted' => 0,
            ]));
        } else {
            $connection->update(self::TABLE, $data, ['uid' => $existing['uid']]);
        }
    }

    public function findByObjectId(int $objectId): ?Patent
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }
}
