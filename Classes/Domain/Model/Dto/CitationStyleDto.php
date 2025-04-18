<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\Dto;

class CitationStyleDto
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
}
