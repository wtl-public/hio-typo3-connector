<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructureDto;
use Wtl\HioTypo3Connector\Domain\Model\ResearchInfrastructure;

class ResearchInfrastructureRepository extends BaseRepository
{
    private const TABLE = 'tx_hiotypo3connector_domain_model_researchinfrastructure';

    public function save(ResearchInfrastructureDto $dto, $storagePageId): void
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TABLE);

        $existing = $connection->select(
            ['uid'], self::TABLE,
            ['object_id' => $dto->getObjectId(), 'deleted' => 0]
        )->fetchAssociative();

        $data = [
            'object_id'    => $dto->getObjectId(),
            'title'        => (string)$dto->getTitle(),
            'details'      => json_encode($dto->getDetails(), JSON_UNESCAPED_UNICODE),
            'search_index' => (string)$dto->getSearchIndex(),
        ];

        if ($existing === false) {
            $connection->insert(self::TABLE, array_merge($data, [
                'pid' => $storagePageId, 'hidden' => 0, 'deleted' => 0,
            ]));
        } else {
            $connection->update(self::TABLE, $data, ['uid' => $existing['uid']]);
        }
    }

    public function findByObjectId(int $objectId): ?ResearchInfrastructure
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }
}
