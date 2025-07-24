<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Dto\OrgUnitDto;
use Wtl\HioTypo3Connector\Domain\Model\OrgUnit;

class OrgUnitRepository extends BaseRepository
{
    public function save(OrgUnitDto $orgUnitDto, $storagePageId): void
    {
        $orgUnitModel = $this->findByObjectId($orgUnitDto->getObjectId());

        if ($orgUnitModel === null) {
            $orgUnitModel = new OrgUnit();
            $orgUnitModel->setObjectId($orgUnitDto->getObjectId());
            $orgUnitModel->setTitle($orgUnitDto->getTitle());
            $orgUnitModel->setDetails($orgUnitDto->getDetails());
            $orgUnitModel->setSearchIndex($orgUnitDto->getSearchIndex());
            $orgUnitModel->setPid($storagePageId);

            $this->add($orgUnitModel);
        } else {
            $orgUnitModel->setObjectId($orgUnitDto->getObjectId());
            $orgUnitModel->setTitle($orgUnitDto->getTitle());
            $orgUnitModel->setDetails($orgUnitDto->getDetails());
            $orgUnitModel->setSearchIndex($orgUnitDto->getSearchIndex());
            $this->update($orgUnitModel);
        }
        $this->persistenceManager->persistAll();
    }

    public function findByObjectId(int $objectId): ?OrgUnit
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }
}
