<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Model\DTO\DoctorateDTO;
use Wtl\HioTypo3Connector\Domain\Model\Doctorate;

class DoctorateRepository extends BaseRepository
{
    public function saveDoctorates($doctorates, $storagePageId): void {
        /** @var DoctorateDTO $dto */
        foreach ($doctorates as $dto) {
            $model = $this->findOneBy(['objectId' => $dto->getObjectId()]);

            if ($model === null) {
                $model = new Doctorate();
                $model->setObjectId($dto->getObjectId());
                $model->setTitle($dto->getTitle());
                $model->setDetails($dto->getDetails());
                $model->setPid($storagePageId);

                $this->add($model);
            } else {
                $model->setObjectId($dto->getObjectId());
                $model->setTitle($dto->getTitle());
                $model->setDetails($dto->getDetails());
                $this->update($model);
            }
        }
        $this->persistenceManager->persistAll();
    }
}
