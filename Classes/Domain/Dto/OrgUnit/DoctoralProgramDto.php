<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\OrgUnit;

use Wtl\HioTypo3Connector\Trait\WithDescription;
use Wtl\HioTypo3Connector\Trait\WithEndDate;
use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithLanguage;
use Wtl\HioTypo3Connector\Trait\WithStartDate;
use Wtl\HioTypo3Connector\Trait\WithTitle;

class DoctoralProgramDto
{
    use WithDescription;
    use WithEndDate;
    use WithId;
    use WithLanguage;
    use WithStartDate;
    use WithTitle;

    protected ?string $courseOfStudy = '';

    public function getCourseOfStudy(): ?string
    {
        return $this->courseOfStudy;
    }

    public function setCourseOfStudy(?string $courseOfStudy): void
    {
        $this->courseOfStudy = $courseOfStudy;
    }

    static public function fromArray(array $data): self
    {
        $dto = new self();
        $dto->setCourseOfStudy($data['courseOfStudy'] ?? '');
        $dto->setDescription($data['description'] ?? '');
        $dto->setEndDate(isset($data['endDate']) ? new \DateTime($data['endDate']) : null);
        $dto->setId($data['id']);
        $dto->setLanguage($data['language'] ?? '');
        $dto->setStartDate(isset($data['startDate']) ? new \DateTime($data['startDate']) : null);
        $dto->setTitle($data['title']);
        return $dto;
    }
}
