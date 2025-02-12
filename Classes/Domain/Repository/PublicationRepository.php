<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Model\DTO\CitationStyleDTO;
use Wtl\HioTypo3Connector\Domain\Model\DTO\PublicationDTO;
use Wtl\HioTypo3Connector\Domain\Model\Person;
use Wtl\HioTypo3Connector\Domain\Model\Publication;

class PublicationRepository extends BaseRepository
{
    public function savePublications($publications, $storagePageId): void {
        /** @var PublicationDTO $publication */
        foreach ($publications as $publication) {
            $publicationModel = $this->findOneBy(['objectId' => $publication->getObjectId()]);
            if ($publicationModel === null) {
                $publicationModel = new Publication();
                $publicationModel->setObjectId($publication->getObjectId());
                $publicationModel->setTitle($publication->getTitle());
                $publicationModel->setType($publication->getType());
                $publicationModel->setDetails($publication->getDetails());
                $publicationModel->setPid($storagePageId);
                $publicationModel->setReleaseYear($publication->getReleaseYear());
                $this->add($publicationModel);
            } else {
                $publicationModel->setObjectId($publication->getObjectId());
                $publicationModel->setTitle($publication->getTitle());
                $publicationModel->setType($publication->getType());
                $publicationModel->setDetails($publication->getDetails());
                $publicationModel->setReleaseYear($publication->getReleaseYear());
                $this->update($publicationModel);
            }

            if ($publication->getCitations() !== null) {
                $citationRepository = new CitationStyleRepository();
                $citationRepository->setPersistenceManager($this->persistenceManager);

                /** @var CitationStyleDTO[] $citationStyles */
                $citationStyles = [];
                foreach ($publication->getCitations() as $citation) {
                    $citationStyle = new CitationStyleDTO();
                    $citationStyle->setLabel($citation->getStyle());
                    $citationStyles[] = $citationStyle;
                }
                $citationRepository->saveCitationStyles($citationStyles);
            }
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
