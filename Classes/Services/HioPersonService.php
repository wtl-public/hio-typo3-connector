<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Model\DTO\PersonDTO;

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
            $personData  = new PersonDTO();
            $personData->setObjectId($person['id']);
            $personData->setName($person['name'] ?? '');
            $personData->setDetails($person);
            $personData->setPublications($person['publications'] ?? []);
            $personData->setProjects($person['projects'] ?? []);
            $persons[] = $personData;
        }
        return $persons ?? [];
    }
}
