<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Utility;

final class NonBmpNormalizer
{
    public static function normalize(string $value): string
    {
        return preg_replace_callback('/[\x{10000}-\x{10FFFF}]/u', static function (array $match): string {
            $normalized = \Normalizer::normalize($match[0], \Normalizer::FORM_KC);
            return preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $normalized === false ? '' : $normalized);
        }, $value);
    }
}
