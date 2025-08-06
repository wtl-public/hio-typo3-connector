<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Dto\DoctoralProgramDto;
use Wtl\HioTypo3Connector\Domain\Model\DoctoralProgram;

class DoctoralProgramRepository extends BaseRepository
{
    public function save(DoctoralProgramDto $doctoralProgramDto, $storagePageId): void
    {
        $doctoralProgramModel = $this->findByObjectId($doctoralProgramDto->getObjectId());

        if ($doctoralProgramModel === null) {
            $doctoralProgramModel = new DoctoralProgram();
            $doctoralProgramModel->setObjectId($doctoralProgramDto->getObjectId());
            $doctoralProgramModel->setTitle($doctoralProgramDto->getTitle());
            $doctoralProgramModel->setDetails($doctoralProgramDto->getDetails());
            $doctoralProgramModel->setSearchIndex($doctoralProgramDto->getSearchIndex());
            $doctoralProgramModel->setPid($storagePageId);

            $this->add($doctoralProgramModel);
        } else {
            $doctoralProgramModel->setObjectId($doctoralProgramDto->getObjectId());
            $doctoralProgramModel->setTitle($doctoralProgramDto->getTitle());
            $doctoralProgramModel->setDetails($doctoralProgramDto->getDetails());
            $doctoralProgramModel->setSearchIndex($doctoralProgramDto->getSearchIndex());
            $this->update($doctoralProgramModel);
        }
        $this->persistenceManager->persistAll();
    }

    public function findByObjectId(int $objectId): ?DoctoralProgram
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }
}
