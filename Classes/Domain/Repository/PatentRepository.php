<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Dto\PatentDto;
use Wtl\HioTypo3Connector\Domain\Model\Patent;

class PatentRepository extends BaseRepository
{
    public function save(PatentDto $patentDto, $storagePageId): void
    {
        $patentModel = $this->findOneBy(['objectId' => $patentDto->getObjectId()]);

        if ($patentModel === null) {
            $patentModel = new Patent();
            $patentModel->setObjectId($patentDto->getObjectId());
            $patentModel->setTitle($patentDto->getTitle());
            $patentModel->setDetails($patentDto->getDetails());
            $patentModel->setSearchIndex($patentDto->getSearchIndex());
            $patentModel->setPid($storagePageId);

            $this->add($patentModel);
        } else {
            $patentModel->setObjectId($patentDto->getObjectId());
            $patentModel->setTitle($patentDto->getTitle());
            $patentModel->setDetails($patentDto->getDetails());
            $patentModel->setSearchIndex($patentDto->getSearchIndex());
            $this->update($patentModel);
        }
        $this->persistenceManager->persistAll();
    }
}
