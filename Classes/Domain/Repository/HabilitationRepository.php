<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wtl\HioTypo3Connector\Domain\Dto\HabilitationDto;
use Wtl\HioTypo3Connector\Domain\Model\Habilitation;

class HabilitationRepository extends BaseRepository
{
    private const TABLE = 'tx_hiotypo3connector_domain_model_habilitation';

    public function save(HabilitationDto $habilitationDto, $storagePageId): void
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TABLE);

        $existing = $connection->select(
            ['uid'], self::TABLE,
            ['object_id' => $habilitationDto->getObjectId(), 'deleted' => 0]
        )->fetchAssociative();

        $data = [
            'object_id'    => $habilitationDto->getObjectId(),
            'title'        => (string)$habilitationDto->getTitle(),
            'details'      => json_encode($habilitationDto->getDetails(), JSON_UNESCAPED_UNICODE),
            'search_index' => (string)$habilitationDto->getSearchIndex(),
        ];

        if ($existing === false) {
            $connection->insert(self::TABLE, array_merge($data, [
                'pid' => $storagePageId, 'hidden' => 0, 'deleted' => 0,
            ]));
        } else {
            $connection->update(self::TABLE, $data, ['uid' => $existing['uid']]);
        }
    }

    public function findByObjectId(int $objectId): ?Habilitation
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }
}
