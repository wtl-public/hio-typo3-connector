<?php

namespace Wtl\HioTypo3Connector\Domain\Repository;

use Wtl\HioTypo3Connector\Domain\Model\Citationstyle;
use Wtl\HioTypo3Connector\Domain\Model\DTO\CitationstyleDTO;

class CitationstyleRepository extends BaseRepository
{
    /**
     * @param CitationstyleDTO[] $citationStyles
     */
    public function saveCitationStyles(array $citationStyles): void {
        foreach ($citationStyles as $citationStyle) {
            $model = $this->findOneBy(['label' => $citationStyle->getLabel()]);

            if ($model === null) {
                $model = new Citationstyle();
                $model->setLabel($citationStyle->getLabel());

                $this->add($model);
            }
        }
        $this->persistenceManager->persistAll();
    }
}
