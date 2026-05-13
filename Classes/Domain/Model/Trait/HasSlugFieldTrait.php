<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Domain\Model\Trait;

trait HasSlugFieldTrait
{
    protected string $slug = '';

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }
}

