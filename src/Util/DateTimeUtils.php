<?php

declare(strict_types=1);

namespace FFTTApi\Util;

use Carbon\Carbon;

final class DateTimeUtils
{
    public static function date(string $datetime, string $format = 'Y-m-d'): Carbon|null
    {
        return Carbon::createFromFormat($format, $datetime);
    }
}
