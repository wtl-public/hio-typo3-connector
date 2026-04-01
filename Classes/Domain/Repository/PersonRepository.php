<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wtl\HioTypo3Connector\Domain\Dto\PersonDto;
use Wtl\HioTypo3Connector\Domain\Model\Person;

class PersonRepository extends BaseRepository
{
    private const TABLE = 'tx_hiotypo3connector_domain_model_person';

    public function save(PersonDto $personDto, int $storagePageId = 0): void
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TABLE);

        $existing = $connection->select(
            ['uid'], self::TABLE,
            ['object_id' => $personDto->getObjectId(), 'deleted' => 0]
        )->fetchAssociative();

        $data = [
            'object_id'    => $personDto->getObjectId(),
            'name'         => (string)$personDto->getName()->getDisplayName(),
            'details'      => json_encode($personDto->getDetails(), JSON_UNESCAPED_UNICODE),
            'search_index' => (string)$personDto->getSearchIndex(),
        ];

        if ($existing === false) {
            $connection->insert(self::TABLE, array_merge($data, [
                'pid' => $storagePageId, 'hidden' => 0, 'deleted' => 0,
            ]));
        } else {
            $connection->update(self::TABLE, $data, ['uid' => $existing['uid']]);
        }
    }

    public function findByObjectId(int $objectId): ?Person
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }
}
