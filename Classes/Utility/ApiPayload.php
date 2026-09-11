<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Utility;

/**
 * A site runs this extension against the middleware it has, so an answer arrives
 * under the current field names or under the ones before them. Every answer
 * passes here first and leaves in one shape, so no DTO and no template below
 * asks which middleware answered.
 */
class ApiPayload
{
    public static function project(array $data): array
    {
        $data = self::rename($data, 'description', 'abstract');
        $data = self::rename($data, 'projectType', 'type');
        $data = self::asObject($data, 'projectType');

        return self::personRoles($data);
    }

    public static function doctoralProgram(array $data): array
    {
        return self::personRoles(self::rename($data, 'orgUnits', 'organizations'));
    }

    /**
     * A project delivers the person role as the object, a doctoral programme and
     * a habilitation still deliver the bare name. Both leave as the object.
     */
    public static function personRoles(array $data): array
    {
        foreach ($data['persons'] ?? [] as $index => $person) {
            if (is_array($person)) {
                $data['persons'][$index] = self::asObject($person, 'role');
            }
        }

        return $data;
    }

    /**
     * Carry the legacy field over under its current name, and drop it. A newer
     * middleware sends the current name and wins — an empty one included, which is
     * why the key decides here and not its value.
     */
    private static function rename(array $data, string $current, string $legacy): array
    {
        if (!array_key_exists($current, $data) && array_key_exists($legacy, $data)) {
            $data[$current] = $data[$legacy];
        }
        unset($data[$legacy]);

        return $data;
    }

    private static function asObject(array $data, string $key): array
    {
        if (is_string($data[$key] ?? null)) {
            $data[$key] = ['name' => $data[$key]];
        }

        return $data;
    }
}
