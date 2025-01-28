<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wtl\HioTypo3Connector\Domain\Model\DTO\PersonDTO;
use Wtl\HioTypo3Connector\Domain\Model\Patent;
use Wtl\HioTypo3Connector\Domain\Model\Person;

class PersonRepository extends BaseRepository
{
    /**
     * @param PersonDTO[] $persons
     * @param int $storagePageId
     */
    public function savePersons(array $persons, $storagePageId): void {
        foreach ($persons as $person) {
            $model = $this->findOneBy(['objectId' => $person->getObjectId()]);
            if ($model === null) {
                $model = new Person();
                $model->setObjectId($person->getObjectId());
                $model->setDetails(json_encode($person->getDetails()));
                $model->setName($person->getName());
                $model->setPid($storagePageId);

                $this->attachPublicationsByObjectIds($model, $person->getPublications());
                $this->attachProjectsByObjectIds($model, $person->getProjects());
                $this->attachPatentsByObjectIds($model, $person->getPatents());
                $this->add($model);
            } else {
                $model->setObjectId($person->getObjectId());
                $model->setDetails(json_encode($person->getDetails()));
                $model->setName($person->getName());

                $this->attachPublicationsByObjectIds($model, $person->getPublications());
                $this->attachProjectsByObjectIds($model, $person->getProjects());
                $this->attachPatentsByObjectIds($model, $person->getPatents());
                $this->update($model);
            }
        }
        $this->persistenceManager->persistAll();
    }

    protected function attachProjectsByObjectIds(Person &$personModel, array $projects): Person
    {
        if (empty($projects)) {
            return $personModel;
        }
        $projectIds = array_map(fn($project) => $project['id'], $projects);
        $projectRepository = GeneralUtility::makeInstance(ProjectRepository::class);
        $query = $projectRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->in('objectId', $projectIds));

        $relatedEntities = $query->execute();
        foreach ($relatedEntities as $relatedEntity) {
            $personModel->addProject($relatedEntity);
        }
        return $personModel;
    }

    protected function attachPublicationsByObjectIds(Person &$personModel, array $publications): Person
    {
        if (empty($publications)) {
            return $personModel;
        }
        $publicationIds = array_map(fn($publication) => $publication['id'], $publications);
        $publicationRepository = GeneralUtility::makeInstance(PublicationRepository::class);
        $query = $publicationRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->in('objectId', $publicationIds));

        $relatedEntities = $query->execute();
        foreach ($relatedEntities as $relatedEntity) {
            $personModel->addPublication($relatedEntity);
        }
        return $personModel;
    }

    protected function attachPatentsByObjectIds(Person &$personModel, array $patents): Person
    {
        if (empty($patents)) {
            return $personModel;
        }
        $patentIds = array_map(fn($patent) => $patent['id'], $patents);
        $patentRepository = GeneralUtility::makeInstance(PatentRepository::class);
        $query = $patentRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->in('objectId', $patentIds));

        $relatedEntities = $query->execute();
        foreach ($relatedEntities as $relatedEntity) {
            $personModel->addPatent($relatedEntity);
        }
        return $personModel;
    }
}
