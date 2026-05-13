<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wtl\HioTypo3Connector\Domain\Dto\DoctoralProgramDto;
use Wtl\HioTypo3Connector\Domain\Model\DoctoralProgram;

class DoctoralProgramRepository extends BaseRepository
{
    private const TABLE = 'tx_hiotypo3connector_domain_model_doctoralprogram';

    public function save(DoctoralProgramDto $doctoralProgramDto, $storagePageId): void
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TABLE);

        $existing = $connection->select(
            ['uid', 'slug'], self::TABLE,
            ['object_id' => $doctoralProgramDto->getObjectId(), 'deleted' => 0]
        )->fetchAssociative();

        $data = [
            'object_id'    => $doctoralProgramDto->getObjectId(),
            'title'        => (string)$doctoralProgramDto->getTitle(),
            'details'      => json_encode($doctoralProgramDto->getDetails(), JSON_UNESCAPED_UNICODE),
            'search_index' => (string)$doctoralProgramDto->getSearchIndex(),
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

    public function findByObjectId(int $objectId): ?DoctoralProgram
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }
}
