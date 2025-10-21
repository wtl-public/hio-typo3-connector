<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\NominationDto;

class HioNominationService extends HioApiService
{
    public function getNominations(int $page = 1): array
    {
        $apiResponse = $this->fetch($page);

        if ($apiResponse->getMeta()->getTotal() === 0) {
            return [];
        }

        $result = $apiResponse->getData();
        $nominations = [];
        foreach ($result as $nomination) {
            $nominations[] = NominationDto::fromArray($nomination);
        }
        return $nominations;
    }
}
