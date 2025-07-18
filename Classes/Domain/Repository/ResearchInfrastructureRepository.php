<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Dto\ResearchInfrastructureDto;
use Wtl\HioTypo3Connector\Domain\Model\ResearchInfrastructure;

class ResearchInfrastructureRepository extends BaseRepository
{
    public function save(ResearchInfrastructureDto $dto, $storagePageId): void
    {
        $model = $this->findByObjectId($dto->getObjectId());

        if ($model === null) {
            $model = new ResearchInfrastructure();
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
        $this->persistenceManager->persistAll();
    }

    public function findByObjectId(int $objectId): ?ResearchInfrastructure
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }
}
