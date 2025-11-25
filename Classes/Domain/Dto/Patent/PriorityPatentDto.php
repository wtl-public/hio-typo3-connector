<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto\Patent;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\StatusDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\VisibilityDto;
use Wtl\HioTypo3Connector\Trait\WithDescription;
use Wtl\HioTypo3Connector\Trait\WithId;
use Wtl\HioTypo3Connector\Trait\WithStatus;
use Wtl\HioTypo3Connector\Trait\WithTitle;
use Wtl\HioTypo3Connector\Trait\WithVisibility;

class PriorityPatentDto
{
    use WithId;
    use WithDescription;
    use WithStatus;
    use WithTitle;
    use WithVisibility;

    protected ?\DateTime $grantDate = null;
    protected string $patentNumber = '';
    protected ?\DateTime $registrationDate = null;

    public function getGrantDate(): ?\DateTime
    {
        return $this->grantDate;
    }

    public function setGrantDate(?\DateTime $grantDate): void
    {
        $this->grantDate = $grantDate;
    }

    public function getPatentNumber(): string
    {
        return $this->patentNumber;
    }

    public function setPatentNumber(string $patentNumber): void
    {
        $this->patentNumber = $patentNumber;
    }

    public function getRegistrationDate(): ?\DateTime
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(?\DateTime $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }

    static public function fromArray(?array $data): ?self
    {
        if ($data === null) {
            return null;
        }
        $dto = new self();
        $dto->setDescription($data['description'] ?? '');
        $dto->setGrantDate(isset($data['grantDate']) ? new \DateTime($data['grantDate']) : null);
        $dto->setId($data['id']);
        $dto->setPatentNumber($data['patentNumber'] ?? '');
        $dto->setRegistrationDate(isset($data['registrationDate']) ? new \DateTime($data['registrationDate']) : null);
        $dto->setStatus(StatusDto::fromArray($data['status']) ?? null);
        $dto->setTitle($data['title']);
        $dto->setVisibility(VisibilityDto::fromArray($data['visibility']) ?? null);
        return $dto;
    }
}
