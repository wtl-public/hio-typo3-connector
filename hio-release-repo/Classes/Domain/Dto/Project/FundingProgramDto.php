<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Project;

class FundingProgramDto
{
    protected string $funderName;
    protected ?string $budgetSource = '';
    protected ?string $budgetSourceCategory = '';
    protected ?string $budgetSourceType = '';
    protected ?string $projectManagement = '';

    public function getFunderName(): string
    {
        return $this->funderName;
    }
    public function setFunderName(string $funderName): void
    {
        $this->funderName = $funderName;
    }

    public function getBudgetSource(): string
    {
        return $this->budgetSource;
    }
    public function setBudgetSource(string $budgetSource): void
    {
        $this->budgetSource = $budgetSource;
    }

    public function getBudgetSourceCategory(): string
    {
        return $this->budgetSourceCategory;
    }
    public function setBudgetSourceCategory(string $budgetSourceCategory): void
    {
        $this->budgetSourceCategory = $budgetSourceCategory;
    }

    public function getBudgetSourceType(): string
    {
        return $this->budgetSourceType;
    }
    public function setBudgetSourceType(string $budgetSourceType): void
    {
        $this->budgetSourceType = $budgetSourceType;
    }

    public function getProjectManagement(): string
    {
        return $this->projectManagement;
    }
    public function setProjectManagement(string $projectManagement): void
    {
        $this->projectManagement = $projectManagement;
    }

    public static function fromArray(array $data): self
    {
        $fundingProgramDto = new self();
        $fundingProgramDto->setFunderName($data['funderName'] ?? '');
        $fundingProgramDto->setBudgetSource($data['budgetSource'] ?? '');
        $fundingProgramDto->setBudgetSourceCategory($data['budgetSourceCategory'] ?? '');
        $fundingProgramDto->setBudgetSourceType($data['budgetSourceType'] ?? '');
        $fundingProgramDto->setProjectManagement($data['projectManagement'] ?? '');

        return $fundingProgramDto;
    }
}
