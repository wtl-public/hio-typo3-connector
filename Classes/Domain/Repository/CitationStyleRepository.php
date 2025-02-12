<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Model\CitationStyle;
use Wtl\HioTypo3Connector\Domain\Model\DTO\CitationStyleDTO;

class CitationStyleRepository extends BaseRepository
{
    /**
     * @param CitationStyleDTO[] $citationStyles
     */
    public function saveCitationStyles(array $citationStyles): void {
        foreach ($citationStyles as $citationStyle) {
            $model = $this->findOneBy(['label' => $citationStyle->getLabel()]);

            if ($model === null) {
                $model = new CitationStyle();
                $model->setLabel($citationStyle->getLabel());

                $this->add($model);
            }
        }
        $this->persistenceManager->persistAll();
    }
}
