<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Dto\HabilitationDto;
use Wtl\HioTypo3Connector\Domain\Model\Habilitation;

class HabilitationRepository extends BaseRepository
{
    public function saveHabilitations($habilitations, $storagePageId): void {
        /** @var HabilitationDto $dto */
        foreach ($habilitations as $dto) {
            $model = $this->findOneBy(['objectId' => $dto->getObjectId()]);

            if ($model === null) {
                $model = new Habilitation();
                $model->setObjectId($dto->getObjectId());
                $model->setTitle($dto->getTitle());
                $model->setDetails($dto->getDetails());
                $model->setSearchIndex($dto->getSearchIndex());
                $model->setPid($storagePageId);

                $this->add($model);
            } else {
                $model->setObjectId($dto->getObjectId());
                $model->setTitle($dto->getTitle());
                $model->setDetails($dto->getDetails());
                $model->setSearchIndex($dto->getSearchIndex());
                $this->update($model);
            }
        }
        $this->persistenceManager->persistAll();
    }
}
