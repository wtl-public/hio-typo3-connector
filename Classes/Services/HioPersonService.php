<?php

namespace Wtl\HioTypo3Connector\Services;

use Wtl\HioTypo3Connector\Domain\Dto\PersonDto;

class HioPersonService extends HioApiService
{
    /**
     * @param (callable(?int, \Throwable): void)|null $onMappingFailure
     * @return PersonDto[]
     */
    public function getPersons(int $page = 1, ?callable $onMappingFailure = null): array
    {
        return $this->fetchMappedPage(
            $page,
            static function (array $person): ?PersonDto {
                return $person['name']['displayName'] ? PersonDto::fromArray($person) : null;
            },
            $onMappingFailure
        );
    }
}
