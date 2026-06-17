<?php

namespace Wtl\HioTypo3Connector\Utility;

class DataUtility
{
    /**
     * @param mixed $value
     * @param string $key
     * @param $fallback
     * @return string|null
     *
     */
    public static function coerceString(mixed $value, string $key = 'name', $fallback = null): ?string
    {
        return match (true) {
            is_string($value)                        => $value,
            is_array($value) && isset($value[$key]) => $value[$key],
            default                                  => $fallback,
        };
    }
}