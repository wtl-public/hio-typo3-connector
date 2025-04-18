<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Model\DTO\PublicationDTO;
use Wtl\HioTypo3Connector\Domain\Model\Person;
use Wtl\HioTypo3Connector\Domain\Model\Publication;

class PublicationRepository extends BaseRepository
{
    public function save(PublicationDTO $publication, int $storagePid = 0): void
    {
        $publicationModel = $this->findOneBy(['objectId' => $publication->getObjectId()]);
        if ($publicationModel === null) {
            $publicationModel = new Publication();
            $publicationModel->setObjectId($publication->getObjectId());
            $publicationModel->setTitle($publication->getTitle());
            $publicationModel->setType($publication->getType());
            $publicationModel->setDetails($publication->getDetails());
            $publicationModel->setSearchIndex($publication->getSearchIndex());
            $publicationModel->setPid($storagePid);
            $publicationModel->setReleaseYear($publication->getReleaseYear());

            $this->add($publicationModel);
        } else {
            $publicationModel->setObjectId($publication->getObjectId());
            $publicationModel->setTitle($publication->getTitle());
            $publicationModel->setType($publication->getType());
            $publicationModel->setDetails($publication->getDetails());
            $publicationModel->setSearchIndex($publication->getSearchIndex());
            $publicationModel->setReleaseYear($publication->getReleaseYear());

            $this->update($publicationModel);
        }
        $this->persistenceManager->persistAll();
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
}
