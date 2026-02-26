<?php

declare(strict_types=1);

namespace FFTTApi\Util;

use Carbon\Carbon;
use BackedEnum;

final readonly class ValueTransformer
{
    public static function nullOrFloat(mixed $value): ?float
    {
        return self::notEmpty($value) && is_numeric($value) ? (float)$value : null;
    }

    public static function nullOrString(mixed $value): ?string
    {
        return self::notEmpty($value) && is_string($value) ? $value : null;
    }

    public static function nullOrInt(mixed $value, bool $zeroIncluded = true): ?int
    {
        $valid = self::notEmpty($value) && is_numeric($value);

        if (!$zeroIncluded) {
            $valid = $valid && $value !== '0';
        }

        return $valid ? (int)$value : null;
    }

    public static function nullOrDate(mixed $value, string $format = 'd/m/Y'): ?Carbon
    {
        return self::notEmpty($value) && is_string($value) ? DateTimeUtils::date($value, $format) : null;
    }

    /**
     * @template T of BackedEnum
     * @param class-string<T> $enum
     * @return T|null
     */
    public static function nullOrEnum(mixed $value, string $enum): ?BackedEnum
    {
        return self::notEmpty($value) ? $enum::from($value) : null;
    }

    public static function exists(mixed $value): bool
    {
        return self::notEmpty($value);
    }

    private static function notEmpty(mixed $value): bool
    {
        $valid = isset($value);

        if (is_string($value)) {
            return $value !== '';
        }

        if (is_array($value)) {
            return $value !== [];
        }

        return $valid;
    }
}
