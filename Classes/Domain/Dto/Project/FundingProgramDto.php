<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Project;

use Wtl\HioTypo3Connector\Trait\WithId;

class FundingProgramDto
{
    use WithId;
    protected string $funderName;
    protected ?BudgetSourceDto $budgetSource;

    public function getFunderName(): string
    {
        return $this->funderName;
    }
    public function setFunderName(string $funderName): void
    {
        $this->funderName = $funderName;
    }

    public function getBudgetSource(): ?BudgetSourceDto
    {
        return $this->budgetSource;
    }
    public function setBudgetSource(?BudgetSourceDto $budgetSource): void
    {
        $this->budgetSource = $budgetSource;
    }

    public static function fromArray(array $data): self
    {
        $fundingProgramDto = new self();
        $fundingProgramDto->setId($data['id']);
        $fundingProgramDto->setFunderName($data['funderName'] ?? '');
        $fundingProgramDto->setBudgetSource(BudgetSourceDto::fromArray($data['budgetSource']) ?? null);

        return $fundingProgramDto;
    }
}
