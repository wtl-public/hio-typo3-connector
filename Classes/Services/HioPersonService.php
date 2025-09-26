<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\PersonDto;

class HioPersonService extends HioApiService
{
    public function getPersons(int $page = 1): array
    {
        $apiResponse = $this->fetch($page);

        if ($apiResponse->getMeta()->getTotal() === 0) {
            return [];
        }

        $result = $apiResponse->getData();
        foreach ($result as $person) {
            if (!$person['name']['displayName']) {
                continue;
            }
            $persons[] = PersonDto::fromArray($person);
        }
        return $persons ?? [];
    }
}
