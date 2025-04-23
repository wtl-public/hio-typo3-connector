<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Dto\HabilitationDto;
use Wtl\HioTypo3Connector\Domain\Model\Habilitation;

class HabilitationRepository extends BaseRepository
{
    public function save(HabilitationDto $habilitationDto, $storagePageId): void
    {
        $habilitationModel = $this->findByObjectId($habilitationDto->getObjectId());

        if ($habilitationModel === null) {
            $habilitationModel = new Habilitation();
            $habilitationModel->setObjectId($habilitationDto->getObjectId());
            $habilitationModel->setTitle($habilitationDto->getTitle());
            $habilitationModel->setDetails($habilitationDto->getDetails());
            $habilitationModel->setSearchIndex($habilitationDto->getSearchIndex());
            $habilitationModel->setPid($storagePageId);

            $this->add($habilitationModel);
        } else {
            $habilitationModel->setObjectId($habilitationDto->getObjectId());
            $habilitationModel->setTitle($habilitationDto->getTitle());
            $habilitationModel->setDetails($habilitationDto->getDetails());
            $habilitationModel->setSearchIndex($habilitationDto->getSearchIndex());
            $this->update($habilitationModel);
        }
        $this->persistenceManager->persistAll();
    }

    public function findByObjectId(string $objectId): ?Habilitation
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }
}
