<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Wtl\HioTypo3Connector\Domain\Dto\Filter\FilterDto as FilterDto;
use Wtl\HioTypo3Connector\Domain\Dto\Filter\PublicationFilter;
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
        if (empty($publicationIds)) {
            return [];
        }

        $query = $this->createQuery();
        $query->setOrderings($ordering);
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->in('objectId', $publicationIds));

        return $query->execute();
    }

    public function findByFilter(PublicationFilter|FilterDto $filter, ?array $ordering = [])
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        
        $constraints = [];

        if ($filter->getSearchTerm()) {
            $searchTerm = trim($filter->getSearchTerm());
            $constraints[] = $query->logicalOr(
                    $query->like('searchIndex', '%' . strtolower($searchTerm) . '%'),
                );
        }
        if ($filter->getReleaseYearFrom()) {
            $constraints[] = 
                    $query->greaterThanOrEqual('releaseYear', $filter->getReleaseYearFrom());
        }

        if ($filter->getReleaseYearTo()) {
            $constraints[] = $query->lessThanOrEqual('releaseYear', $filter->getReleaseYearTo());
            
        }
        if ($filter->getType()) {
            $constraints[] =
                $query->equals('type', $filter->getType()
            );
        }

        if (!empty($constraints)) {
            $query->matching($query->logicalAnd(...$constraints));
        }

        // Apply ordering if provided
        if ($ordering) {
            $query->setOrderings($ordering);
        }

        return $query->execute();
    }

    public function getPublications(?array $ordering = [])
    {
        $query = $this->createQuery();
        $query->setOrderings($ordering);
        $query->getQuerySettings()->setRespectStoragePage(false);

        return $query->execute();
    }

    public function countPublicationsByTypeAndPerson(Person $person)
    {
        $publicationIds = [];
        foreach ($person->getPublications() as $publication) {
            $publicationIds[] = $publication->getObjectId();
        }

        if (empty($publicationIds)) {
            return [];
        }

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->statement(
            'SELECT type, COUNT(*) as count FROM tx_hiotypo3connector_domain_model_publication WHERE object_id IN (' . implode(',', $publicationIds) . ') GROUP BY type ORDER BY count DESC'
        );

        return $query->execute(true);
    }

    public function getPublicationTypes()
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->statement(
            'SELECT DISTINCT type FROM tx_hiotypo3connector_domain_model_publication WHERE type IS NOT NULL ORDER BY type'
        );
        return $query->execute(true);
    }
}
