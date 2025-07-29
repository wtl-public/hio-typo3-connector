<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Dto\PublicationDto;
use Wtl\HioTypo3Connector\Domain\Model\Person;
use Wtl\HioTypo3Connector\Domain\Model\Publication;

class PublicationRepository extends BaseRepository
{
    public function save(PublicationDto $publicationDto, int $storagePid = 0): void
    {
        $publicationModel = $this->findByObjectId($publicationDto->getObjectId());
        if ($publicationModel === null) {
            $publicationModel = new Publication();
            $publicationModel->setObjectId($publicationDto->getObjectId());
            $publicationModel->setTitle($publicationDto->getTitle());
            $publicationModel->setType($publicationDto->getType());
            $publicationModel->setDetails($publicationDto->getDetails());
            $publicationModel->setSearchIndex($publicationDto->getSearchIndex());
            $publicationModel->setPid($storagePid);
            $publicationModel->setReleaseYear($publicationDto->getReleaseYear());

            $this->add($publicationModel);
        } else {
            $publicationModel->setObjectId($publicationDto->getObjectId());
            $publicationModel->setTitle($publicationDto->getTitle());
            $publicationModel->setType($publicationDto->getType());
            $publicationModel->setDetails($publicationDto->getDetails());
            $publicationModel->setSearchIndex($publicationDto->getSearchIndex());
            $publicationModel->setReleaseYear($publicationDto->getReleaseYear());

            $this->update($publicationModel);
        }
        $this->persistenceManager->persistAll();
    }

    public function findByObjectId(int $objectId): ?Publication
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }

    public function getPublicationsByPerson(Person $person, ?array $ordering = [])
    {
        $publicationIds = [];
        foreach ($person->getPublications() as $publication) {
            $publicationIds[] = $publication->getObjectId();
        }

        $query = $this->createQuery();
        $query->setOrderings($ordering);
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->in('objectId', $publicationIds));

        return $query->execute();
    }

    public function getPublications(?array $ordering = [])
    {
        $query = $this->createQuery();
        $query->setOrderings($ordering);
        $query->getQuerySettings()->setRespectStoragePage(false);

        return $query->execute();
    }
}
