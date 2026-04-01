<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wtl\HioTypo3Connector\Domain\Dto\Publication\CitationDto;

class CitationStyleRepository extends BaseRepository
{
    private const TABLE = 'tx_hiotypo3connector_domain_model_citationstyle';

    public function saveCitationStyles(array $citations): void
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TABLE);

        foreach ($citations as $citation) {
            $citationDto = CitationDto::fromArray($citation);
            $label = $citationDto->getStyle();

            $exists = $connection->select(
                ['uid'], self::TABLE,
                ['label' => $label, 'deleted' => 0]
            )->fetchOne();

            if ($exists === false) {
                $connection->insert(self::TABLE, [
                    'label'   => $label,
                    'hidden'  => 0,
                    'deleted' => 0,
                ]);
            }
        }
    }
}
