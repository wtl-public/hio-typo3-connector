<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Dto\Publication\CitationDto;
use Wtl\HioTypo3Connector\Domain\Model\CitationStyle;

class CitationStyleRepository extends BaseRepository
{
    public function saveCitationStyles(array $citations): void {
        /** @var CitationDto $citation */
        foreach ($citations as $citation) {
            $dto = CitationDto::fromArray($citation);
            $model = $this->findOneBy(['label' => $dto->getStyle()]);

            if ($model === null) {
                $model = new CitationStyle();
                $model->setLabel($dto->getStyle());

                $this->add($model);
            }
        }
        $this->persistenceManager->persistAll();
    }
}
