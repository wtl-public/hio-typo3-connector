<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wtl\HioTypo3Connector\Domain\Model\DTO\PersonDTO;
use Wtl\HioTypo3Connector\Domain\Model\Person;

class PersonRepository extends BaseRepository
{
    public function save(PersonDTO $hioPerson, int $storagePageId = 0): void
    {
        $model = $this->findOneBy(['objectId' => $hioPerson->getObjectId()]);
        if ($model === null) {
            $model = new Person();
            $model->setObjectId($hioPerson->getObjectId());
            $model->setDetails(json_encode($hioPerson->getDetails()));
            $model->setSearchIndex($hioPerson->getSearchIndex());
            $model->setName($hioPerson->getName());
            $model->setPid($storagePageId);

            $this->attachPublicationsByObjectIds($model, $hioPerson->getPublications());
            $this->attachProjectsByObjectIds($model, $hioPerson->getProjects());
            $this->attachPatentsByObjectIds($model, $hioPerson->getPatents());
            $this->attachDoctoratesByObjectIds($model, $hioPerson->getDoctorates());
            $this->attachHabilitationsByObjectIds($model, $hioPerson->getHabilitations());
            $this->add($model);
        } else {
            $model->setObjectId($hioPerson->getObjectId());
            $model->setDetails(json_encode($hioPerson->getDetails()));
            $model->setSearchIndex($hioPerson->getSearchIndex());
            $model->setName($hioPerson->getName());

            $this->attachPublicationsByObjectIds($model, $hioPerson->getPublications());
            $this->attachProjectsByObjectIds($model, $hioPerson->getProjects());
            $this->attachPatentsByObjectIds($model, $hioPerson->getPatents());
            $this->attachDoctoratesByObjectIds($model, $hioPerson->getDoctorates());
            $this->attachHabilitationsByObjectIds($model, $hioPerson->getHabilitations());
            $this->update($model);
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

    protected function attachDoctoratesByObjectIds(Person &$personModel, array $doctorates): Person
    {
        if (empty($doctorates)) {
            return $personModel;
        }
        $ids = array_map(fn($doctorate) => $doctorate['id'], $doctorates);
        $repository = GeneralUtility::makeInstance(DoctorateRepository::class);
        $query = $repository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->in('objectId', $ids));

        $relatedEntities = $query->execute();
        foreach ($relatedEntities as $relatedEntity) {
            $personModel->addDoctorate($relatedEntity);
        }
        return $personModel;
    }

    protected function attachHabilitationsByObjectIds(Person &$personModel, array $habilitations): Person
    {
        if (empty($habilitations)) {
            return $personModel;
        }
        $ids = array_map(fn($habilitation) => $habilitation['id'], $habilitations);
        $repository = GeneralUtility::makeInstance(HabilitationRepository::class);
        $query = $repository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->in('objectId', $ids));

        $relatedEntities = $query->execute();
        foreach ($relatedEntities as $relatedEntity) {
            $personModel->addHabilitation($relatedEntity);
        }
        return $personModel;
    }
}
