<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Dto\Filter\FilterDto;
use Wtl\HioTypo3Connector\Domain\Dto\Filter\ProjectFilter;
use Wtl\HioTypo3Connector\Domain\Dto\ProjectDto;
use Wtl\HioTypo3Connector\Domain\Model\Project;

class ProjectRepository extends BaseRepository
{
    public function save(ProjectDto $projectDto, $storagePageId): void
    {
        $projectModel = $this->findByObjectId($projectDto->getObjectId());

        if ($projectModel === null) {
            $projectModel = new Project();
            $projectModel->setPid($storagePageId);
            $projectModel->setObjectId($projectDto->getObjectId());
            $projectModel->setDetails($projectDto->getDetails());
            $projectModel->setSearchIndex($projectDto->getSearchIndex());

            $budgetSourceTypes = $projectModel->extractBudgetSourceTypes($projectDto->getDetails());
            $projectModel->setBudgetSourceTypes($budgetSourceTypes);
            $projectModel->setEndDate($projectDto->getEndDate());
            $projectModel->setStartDate($projectDto->getStartDate());
            $projectModel->setStatus($projectDto->getStatus()->getName());
            $projectModel->setTitle($projectDto->getTitle());
            $projectModel->setType($projectDto->getType());
            $this->add($projectModel);
        } else {
            $projectModel->setObjectId($projectDto->getObjectId());
            $projectModel->setDetails($projectDto->getDetails());
            $projectModel->setSearchIndex($projectDto->getSearchIndex());

            $budgetSourceTypes = $projectModel->extractBudgetSourceTypes($projectDto->getDetails());
            $projectModel->setBudgetSourceTypes($budgetSourceTypes);
            $projectModel->setEndDate($projectDto->getEndDate());
            $projectModel->setStartDate($projectDto->getStartDate());
            $projectModel->setStatus($projectDto->getStatus()->getName());
            $projectModel->setTitle($projectDto->getTitle());
            $projectModel->setType($projectDto->getType());
            $this->update($projectModel);
        }

        $this->persistenceManager->persistAll();
    }

    public function findByObjectId(int $objectId): ?Project
    {
        return $this->findOneBy(['objectId' => $objectId]);
    }

    public function findByFilter(ProjectFilter|FilterDto $filter, ?array $ordering = [])
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
        if ($filter->getStartDateFrom()) {
            $constraints[] = $query->greaterThanOrEqual('startDate', $filter->getStartDateFrom());
        }

        if ($filter->getStartDateTo()) {
            $constraints[] = $query->lessThanOrEqual('startDate', $filter->getStartDateTo());
        }

        if ($filter->getEndDateFrom()) {
            $constraints[] = $query->greaterThanOrEqual('endDate', $filter->getEndDateFrom());
        }

        if ($filter->getEndDateTo()) {
            $constraints[] = $query->lessThanOrEqual('endDate', $filter->getEndDateTo());
        }

        if ($filter->getBudgetSourceTypes()) {
            if (is_array($filter->getBudgetSourceTypes())) {
                $budgetSourceTypeConstraints = [];
                foreach ($filter->getBudgetSourceTypes() as $budgetSourceType) {
                    $budgetSourceTypeConstraints[] = $query->like('budgetSourceTypes', '%' . $budgetSourceType . '%');
                }
                $constraints[] = $query->logicalOr(...$budgetSourceTypeConstraints);
            }
        }

        if ($filter->getStatus()) {
            $constraints[] = $query->equals('status', $filter->getStatus());
        }

        if ($filter->getType()) {
            $constraints[] = $query->equals('type', $filter->getType());
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

    public function getProjectStatus()
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->statement(
            'SELECT DISTINCT status FROM tx_hiotypo3connector_domain_model_project WHERE status IS NOT NULL AND status != "" ORDER BY status'
        );
        return $query->execute(true);
    }

    public function getProjectTypes()
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->statement(
            'SELECT DISTINCT type FROM tx_hiotypo3connector_domain_model_project WHERE type IS NOT NULL AND type != "" ORDER BY type'
        );
        return $query->execute(true);
    }

    public function getProjectBudgetSourceTypes()
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->statement(
            'SELECT DISTINCT budget_source_types FROM tx_hiotypo3connector_domain_model_project WHERE budget_source_types IS NOT NULL AND budget_source_types != ""'
        );
        $resultSet = $query->execute(true);
        if (!$resultSet) {
            return [];
        }

        $budgetSourceTypes = [];
        foreach ($resultSet as $result) {
            $allTypes = explode(',', $result['budget_source_types']);
            $budgetSourceTypes = array_merge($budgetSourceTypes ?? [], $allTypes);
        }

        $budgetSourceTypes = array_unique($budgetSourceTypes);
        sort($budgetSourceTypes);

        return $budgetSourceTypes;
    }
}
