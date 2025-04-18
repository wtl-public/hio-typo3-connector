<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Model\Dto\PersonDto;

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
            $personDto  = new PersonDto();
            $personDto->setObjectId($person['id']);
            $personDto->setName($person['name'] ?? '');
            $personDto->setDetails($person);
            $personDto->setSearchIndex($person);
            $personDto->setPublications($person['publications'] ?? []);
            $personDto->setProjects($person['projects'] ?? []);
            $personDto->setPatents($person['patents'] ?? []);
            $personDto->setDoctorates($person['doctorates'] ?? []);
            $personDto->setHabilitations($person['habilitations'] ?? []);

            $persons[] = $personDto;

        }
        return $persons ?? [];
    }
}
