<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Model\CitationStyle;
use Wtl\HioTypo3Connector\Domain\Model\DTO\Publication\CitationDTO;

class CitationStyleRepository extends BaseRepository
{
    public function saveCitationStyles(array $citations): void {
        /** @var CitationDTO $citation */
        foreach ($citations as $citation) {
            $dto = CitationDTO::fromArray($citation);
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
