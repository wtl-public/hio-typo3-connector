<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Model\DTO\PatentDTO;
use Wtl\HioTypo3Connector\Domain\Model\Patent;

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
                $patentModel->setPid($storagePageId);

                $this->add($patentModel);
            } else {
                $patentModel->setObjectId($patent->getObjectId());
                $patentModel->setTitle($patent->getTitle());
                $patentModel->setDetails($patent->getDetails());
                $this->update($patentModel);
            }
        }
        $this->persistenceManager->persistAll();
    }
}
