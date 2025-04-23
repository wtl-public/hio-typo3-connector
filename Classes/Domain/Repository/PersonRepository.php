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
            $personModel->setDetails(json_encode($personDto->getDetails()));
            $personModel->setSearchIndex($personDto->getSearchIndex());
            $personModel->setName($personDto->getName());
            $personModel->setPid($storagePageId);

            // $this->attachPublicationsByObjectIds($personModel, $personDto->getPublications());
            $this->attachProjectsByObjectIds($personModel, $personDto->getProjects());
            $this->attachPatentsByObjectIds($personModel, $personDto->getPatents());
            $this->attachDoctoratesByObjectIds($personModel, $personDto->getDoctorates());
            $this->attachHabilitationsByObjectIds($personModel, $personDto->getHabilitations());
            $this->add($personModel);
        } else {
            $personModel->setObjectId($personDto->getObjectId());
            $personModel->setDetails(json_encode($personDto->getDetails()));
            $personModel->setSearchIndex($personDto->getSearchIndex());
            $personModel->setName($personDto->getName());

            // $this->attachPublicationsByObjectIds($personModel, $personDto->getPublications());
            $this->attachProjectsByObjectIds($personModel, $personDto->getProjects());
            $this->attachPatentsByObjectIds($personModel, $personDto->getPatents());
            $this->attachDoctoratesByObjectIds($personModel, $personDto->getDoctorates());
            $this->attachHabilitationsByObjectIds($personModel, $personDto->getHabilitations());
            $this->update($personModel);
        }
        $this->persistenceManager->persistAll();
    }

    public function findByObjectId(int $objectId): ?Person
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }

    protected function attachProjectsByObjectIds(Person &$personModel, array $projects): Person
    {
        if (empty($projects)) {
            return $personModel;
        }
        $projectIds = array_map(fn($project) => $project->getObjectId(), $projects);
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
        $patentIds = array_map(fn($patent) => $patent->getObjectId(), $patents);
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
        $ids = array_map(fn($doctorate) => $doctorate->getObjectId(), $doctorates);
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
        $ids = array_map(fn($habilitation) => $habilitation->getObjectId(), $habilitations);
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
