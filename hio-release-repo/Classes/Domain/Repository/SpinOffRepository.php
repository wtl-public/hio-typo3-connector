<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Dto\SpinOffDto;
use Wtl\HioTypo3Connector\Domain\Model\SpinOff;

class SpinOffRepository extends BaseRepository
{
    public function save(SpinOffDto $spinOffDto, $storagePageId): void
    {
        $spinOffModel = $this->findByObjectId($spinOffDto->getObjectId());

        if ($spinOffModel === null) {
            $spinOffModel = new SpinOff();
            $spinOffModel->setObjectId($spinOffDto->getObjectId());
            $spinOffModel->setName($spinOffDto->getName());
            $spinOffModel->setDetails($spinOffDto->getDetails());
            $spinOffModel->setSearchIndex($spinOffDto->getSearchIndex());
            $spinOffModel->setPid($storagePageId);

            $this->add($spinOffModel);
        } else {
            $spinOffModel->setObjectId($spinOffDto->getObjectId());
            $spinOffModel->setName($spinOffDto->getName());
            $spinOffModel->setDetails($spinOffDto->getDetails());
            $spinOffModel->setSearchIndex($spinOffDto->getSearchIndex());
            $this->update($spinOffModel);
        }
        $this->persistenceManager->persistAll();
    }

    public function findByObjectId(int $objectId): ?SpinOff
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }
}
