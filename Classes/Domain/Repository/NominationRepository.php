<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Dto\Filter\FilterDto;
use Wtl\HioTypo3Connector\Domain\Dto\NominationDto;
use Wtl\HioTypo3Connector\Domain\Model\Nomination;

class NominationRepository extends BaseRepository
{
    public function save(NominationDto $dto, $storagePageId): void
    {
        $model = $this->findByObjectId($dto->getObjectId());

        if ($model === null) {
            $model = new Nomination();
            $model->setNominationYear($dto->getNominationYear());
            $model->setObjectId($dto->getObjectId());
            $model->setScope($dto->getScope());
            $model->setStatus($dto->getStatus()->getName());
            $model->setTitle($dto->getTitle());
            $model->setType($dto->getType());
            $model->setVisibility($dto->getVisibility()->getName());
            $model->setDetails($dto->getDetails());
            $model->setSearchIndex($dto->getSearchIndex());
            $model->setPid($storagePageId);

            $this->add($model);
        } else {
            $model->setNominationYear($dto->getNominationYear());
            $model->setObjectId($dto->getObjectId());
            $model->setScope($dto->getScope());
            $model->setStatus($dto->getStatus()->getName());
            $model->setTitle($dto->getTitle());
            $model->setType($dto->getType());
            $model->setVisibility($dto->getVisibility()->getName());
            $model->setDetails($dto->getDetails());
            $model->setSearchIndex($dto->getSearchIndex());
            $this->update($model);
        }
        $this->persistenceManager->persistAll();
    }

    public function findByObjectId(int $objectId): ?Nomination
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }

    public function findByFilter(NominationFilter|FilterDto $filter, ?array $ordering = [])
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

        if (!empty($constraints)) {
            $query->matching($query->logicalAnd(...$constraints));
        }

        // Apply ordering if provided
        if ($ordering) {
            $query->setOrderings($ordering);
        }

        return $query->execute();
    }
}
