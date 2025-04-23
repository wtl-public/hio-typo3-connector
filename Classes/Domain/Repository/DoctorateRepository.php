<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Dto\DoctorateDto;
use Wtl\HioTypo3Connector\Domain\Model\Doctorate;

class DoctorateRepository extends BaseRepository
{
    public function save(DoctorateDto $doctorateDto, $storagePageId): void
    {
        $doctorateModel = $this->findByObjectId($doctorateDto->getObjectId());

        if ($doctorateModel === null) {
            $doctorateModel = new Doctorate();
            $doctorateModel->setObjectId($doctorateDto->getObjectId());
            $doctorateModel->setTitle($doctorateDto->getTitle());
            $doctorateModel->setDetails($doctorateDto->getDetails());
            $doctorateModel->setSearchIndex($doctorateDto->getSearchIndex());
            $doctorateModel->setPid($storagePageId);

            $this->add($doctorateModel);
        } else {
            $doctorateModel->setObjectId($doctorateDto->getObjectId());
            $doctorateModel->setTitle($doctorateDto->getTitle());
            $doctorateModel->setDetails($doctorateDto->getDetails());
            $doctorateModel->setSearchIndex($doctorateDto->getSearchIndex());
            $this->update($doctorateModel);
        }
        $this->persistenceManager->persistAll();
    }

    public function findByObjectId(int $objectId): ?Doctorate
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }
}
