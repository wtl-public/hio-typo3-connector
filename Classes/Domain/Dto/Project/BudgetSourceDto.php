<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Project;

use Wtl\HioTypo3Connector\Domain\Dto\Project\BudgetSource\BudgetSourceCategoryDto;
use Wtl\HioTypo3Connector\Domain\Dto\Project\BudgetSource\BudgetSourceTypeDto;
use Wtl\HioTypo3Connector\Domain\Dto\Project\BudgetSource\FunderCategoryKdsfDto;
use Wtl\HioTypo3Connector\Domain\Dto\Project\BudgetSource\ProjectManagementDto;
use Wtl\HioTypo3Connector\Domain\Dto\Project\BudgetSource\ResearchPartnerDto;
use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithName;
use Wtl\HioTypo3Connector\Trait\WithStatus;

class BudgetSourceDto
{
    use WithId;
    use WithName;
    use WithStatus;

    protected ?BudgetSourceCategoryDto $budgetSourceCategory;
    protected ?BudgetSourceTypeDto $budgetSourceType;
    protected ?FunderCategoryKdsfDto $funderCategoryKdsf;
    protected ?ProjectManagementDto $projectManagement;
    protected ?ResearchPartnerDto $researchPartner;

    public function getBudgetSourceCategory(): ?BudgetSourceCategoryDto
    {
        return $this->budgetSourceCategory;
    }
    public function setBudgetSourceCategory(?BudgetSourceCategoryDto $budgetSourceCategory): void
    {
        $this->budgetSourceCategory = $budgetSourceCategory;
    }

    public function getBudgetSourceType(): ?BudgetSourceTypeDto
    {
        return $this->budgetSourceType;
    }
    public function setBudgetSourceType(?BudgetSourceTypeDto $budgetSourceType): void
    {
        $this->budgetSourceType = $budgetSourceType;
    }

    public function getFunderCategoryKdsf(): ?FunderCategoryKdsfDto
    {
        return $this->funderCategoryKdsf;
    }
    public function setFunderCategoryKdsf(?FunderCategoryKdsfDto $funderCategoryKdsf): void
    {
        $this->funderCategoryKdsf = $funderCategoryKdsf;
    }

    public function getProjectManagement(): ?ProjectManagementDto
    {
        return $this->projectManagement;
    }
    public function setProjectManagement(?ProjectManagementDto $projectManagement): void
    {
        $this->projectManagement = $projectManagement;
    }

    public function getResearchPartner(): ?ResearchPartnerDto
    {
        return $this->researchPartner;
    }
    public function setResearchPartner(?ResearchPartnerDto $researchPartner): void
    {
        $this->researchPartner = $researchPartner;
    }

    public static function fromArray(array $data): self
    {
        $fundingProgramDto = new self();
        $fundingProgramDto->setId($data['id']);
        $fundingProgramDto->setBudgetSourceCategory(BudgetSourceCategoryDto::fromArray($data['budgetSourceCategory']) ?? null);
        $fundingProgramDto->setBudgetSourceType(BudgetSourceTypeDto::fromArray($data['budgetSourceType']) ?? null);
        $fundingProgramDto->setFunderCategoryKdsf(FunderCategoryKdsfDto::fromArray($data['funderCategoryKdsf']) ?? null);
        $fundingProgramDto->setProjectManagement(ProjectManagementDto::fromArray($data['projectManagement']) ?? null);
        $fundingProgramDto->setResearchPartner(ResearchPartnerDto::fromArray($data['researchPartner']) ?? null);

        return $fundingProgramDto;
    }
}
