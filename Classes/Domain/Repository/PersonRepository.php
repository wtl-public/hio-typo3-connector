<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wtl\HioTypo3Connector\Domain\Dto\PersonDto;
use Wtl\HioTypo3Connector\Domain\Model\Person;

class PersonRepository extends BaseRepository
{
    public function save(PersonDto $personDto, int $storagePageId = 0): void
    {
        $personModel = $this->findByObjectId($personDto->getObjectId());
        if ($personModel === null) {
            $personModel = new Person();
            $personModel->setObjectId($personDto->getObjectId());
            $personModel->setDetails($personDto->getDetails());
            $personModel->setSearchIndex($personDto->getSearchIndex());
            $personModel->setName($personDto->getName());
            $personModel->setPid($storagePageId);
            $this->add($personModel);
        } else {
            $personModel->setObjectId($personDto->getObjectId());
            $personModel->setDetails($personDto->getDetails());
            $personModel->setSearchIndex($personDto->getSearchIndex());
            $personModel->setName($personDto->getName());
            $this->update($personModel);
        }
        $this->persistenceManager->persistAll();
    }

    public function findByObjectId(int $objectId): ?Person
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }
}
