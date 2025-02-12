<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\DTO;

use Wtl\HioTypo3Connector\Domain\Model\Citationstyle;

class CitationstyleDTO
{
    protected string $label = '';

    public function getLabel(): string
    {
        return $this->label;
    }
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    static public function fromDomainModel(Citationstyle $model): self
    {
        $dto = new self();
        $dto->setLabel($model->getLabel());

        return $dto;
    }
}
