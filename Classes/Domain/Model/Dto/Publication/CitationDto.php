<?php
declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\Dto\Publication;

class CitationDto
{
    protected string $citation = '';
    protected string $style = '';

    public function getCitation(): string
    {
        return $this->citation;
    }
    public function setCitation(string $citation): void
    {
        $this->citation = $citation;
    }

    public function getStyle(): string
    {
        return $this->style;
    }
    public function setStyle(string $style): void
    {
        $this->style = $style;
    }

    static public function fromArray(array $data): self
    {
        if (count($data) === 0) {
            return new self();
        }
        $dto = new self();
        $dto->setCitation($data['citation']);
        $dto->setStyle($data['style'] );

        return $dto;
    }
}
