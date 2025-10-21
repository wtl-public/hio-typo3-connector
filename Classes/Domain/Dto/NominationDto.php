<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use DateTime;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\StatusDto;
use Wtl\HioTypo3Connector\Domain\Dto\Misc\VisibilityDto;
use Wtl\HioTypo3Connector\Domain\Dto\Nomination\NomineeDto;
use Wtl\HioTypo3Connector\Domain\Dto\Nomination\OrgUnitDto;
use Wtl\HioTypo3Connector\Domain\Dto\Nomination\PrizeDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\ProjectDto;
use Wtl\HioTypo3Connector\Domain\Dto\OrgUnit\PublicationDto;
use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithDynamicObjects;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;
use Wtl\HioTypo3Connector\Trait\WithStatus;
use Wtl\HioTypo3Connector\Trait\WithTitle;
use Wtl\HioTypo3Connector\Trait\WithType;
use Wtl\HioTypo3Connector\Trait\WithVisibility;

class NominationDto
{
    use WithDetails;
    use WithDynamicObjects;
    use WithObjectId;
    use WithSearchIndex;
    use WithStatus;
    use WithTitle;
    use WithType;
    use WithVisibility;

    protected ?DateTime $entryDate = null;
    protected ?int $nominationYear = null;
    /** @var NomineeDto[] */
    protected ?array $nominees = null;
    /** @var OrgUnitDto[] */
    protected ?array $orgUnits = null;
    protected ?PrizeDto $prize = null;
    protected ?array $projects = null;
    protected ?array $publications = null;
    protected ?string $scope = null;

    public function getEntryDate(): DateTime|null
    {
        return $this->entryDate;
    }
    public function setEntryDate(?DateTime $entryDate): void
    {
        $this->entryDate = $entryDate;
    }

    public function getNominationYear(): int|null
    {
        return $this->nominationYear;
    }
    public function setNominationYear(?int $nominationYear): void
    {
        $this->nominationYear = $nominationYear;
    }

    public function getNominees(): ?array
    {
        return $this->nominees;
    }
    public function setNominees(array $nominees): void
    {
        $this->nominees = $nominees;
    }

    public function getOrgUnits(): array
    {
        return $this->orgUnits;
    }
    public function setOrgUnits(array $orgUnits): void
    {
        $this->orgUnits = $orgUnits;
    }

    public function getPrize(): ?PrizeDto
    {
        return $this->prize;
    }
    public function setPrize(PrizeDto|null $prize): void
    {
        $this->prize = $prize;
    }
    public function getProjects(): array
    {
        return $this->projects;
    }
    public function setProjects(array $projects): void
    {
        $this->projects = $projects;
    }

    public function getPublications(): array
    {
        return $this->publications;
    }

    public function setPublications(array $publications): void
    {
        $this->publications = $publications;
    }
    public function getScope(): ?string
    {
        return $this->scope;
    }
    public function setScope(?string $scope): void
    {
        $this->scope = $scope;
    }

    static public function fromArray(array $data): NominationDto
    {
        $dto = new self();

        $dto->setDetails($data);
        if (isset($data['entryDate'])) {
            $dto->setEntryDate(new DateTime($data['entryDate']));
        }
        $dto->setNominationYear($data['nominationYear'] ?? null);
        $dto->setNominees(array_map(fn($item) => NomineeDto::fromArray($item), $data['nominees'] ?? []));
        $dto->setObjectId($data['id']);
        $dto->setOrgUnits(array_map(fn($item) => OrgUnitDto::fromArray($item), $data['orgUnits'] ?? []));
        $dto->setProjects(array_map(fn($item) => ProjectDto::fromArray($item), $data['projects'] ?? []));
        $dto->setPrize(isset($data['prize']) ? PrizeDto::fromArray($data['prize']) : null);
        $dto->setPublications(array_map(fn($item) => PublicationDto::fromArray($item), $data['publications'] ?? []));
        $dto->setScope($data['scope'] ?? '');
        $dto->setSearchIndex($data);
        $dto->setStatus(StatusDto::fromArray($data['status']) ?? null);
        $dto->setTitle($data['title'] ?? '');
        $dto->setType($data['type'] ?? '');
        $dto->setVisibility(VisibilityDto::fromArray($data['visibility']) ?? '');

        return $dto;
    }
}
