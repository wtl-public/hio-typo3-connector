<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use Wtl\HioTypo3Connector\Domain\Dto\PatentDto;
use Wtl\HioTypo3Connector\Domain\Model\Patent;

class PatentRepository extends BaseRepository
{
    public function savePatents($patents, $storagePageId): void {
        /** @var PatentDto $patent */
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
