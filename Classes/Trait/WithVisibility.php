<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Trait;

use Wtl\HioTypo3Connector\Domain\Dto\Misc\VisibilityDto;

trait WithVisibility
{
    protected ?VisibilityDto $visibility;

    public function getVisibility(): ?VisibilityDto
    {
        return $this->visibility;
    }

    public function setVisibility(?VisibilityDto $visibility): void
    {
        $this->visibility = $visibility;
    }
}
