<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wtl\HioTypo3Connector\Domain\Model\Patent;
use Wtl\HioTypo3Connector\Domain\Model\DTO\PatentDTO;
use Wtl\HioTypo3Connector\Domain\Repository\BaseRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

class PatentRepository extends BaseRepository
{
    public function savePatents($patents, $storagePageId): void {
        /** @var PatentDTO $patent */
        foreach ($patents as $patent) {
            $patentModel = $this->findOneBy(['objectId' => $patent->getObjectId()]);

            if ($patentModel === null) {
                $patentModel = new Patent();
                $patentModel->setObjectId($patent->getObjectId());
                $patentModel->setTitle($patent->getTitle());
                $patentModel->setDetails($patent->getDetails());
                $patentModel->setSearchIndex($patent->getSearchIndex());
                $patentModel->setPid($storagePageId);

                $this->add($patentModel);
            } else {
                $patentModel->setObjectId($patent->getObjectId());
                $patentModel->setTitle($patent->getTitle());
                $patentModel->setDetails($patent->getDetails());
                $patentModel->setSearchIndex($patent->getSearchIndex());
                $this->update($patentModel);
            }
        }
        $this->persistenceManager->persistAll();
    }
}
