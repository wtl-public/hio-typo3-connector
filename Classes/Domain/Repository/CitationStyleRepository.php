<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Dto\Publication\CitationDto;
use Wtl\HioTypo3Connector\Domain\Model\CitationStyle;

class CitationStyleRepository extends BaseRepository
{
    public function saveCitationStyles(array $citations): void {
        /** @var CitationDto $citation */
        foreach ($citations as $citation) {
            $citationDto = CitationDto::fromArray($citation);
            $citationModel = $this->findOneBy(['label' => $citationDto->getStyle()]);

            if ($citationModel === null) {
                $citationModel = new CitationStyle();
                $citationModel->setLabel($citationDto->getStyle());

                $this->add($citationModel);
            }
        }
        $this->persistenceManager->persistAll();
    }
}
