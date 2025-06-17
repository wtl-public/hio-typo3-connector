<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Wtl\HioTypo3Connector\Trait\WithDetails;
use Wtl\HioTypo3Connector\Trait\WithObjectId;
use Wtl\HioTypo3Connector\Trait\WithSearchIndex;

class OrgUnitDto
{
    use WithObjectId;
    use WithDetails;
    use WithSearchIndex;

    protected string $title = '';

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    static public function fromArray(array $data): OrgUnitDto
    {
        $dto = new self();
        $dto->setObjectId($data['id']);
        $dto->setDetails($data);
        $dto->setSearchIndex($data);

        $dto->setTitle($data['name'] ?? '');

        return $dto;
    }
}
