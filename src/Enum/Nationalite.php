<?php

declare(strict_types=1);

namespace FFTTApi\Enum;

enum Nationalite: string
{
    case FRANCAISE = 'F';
    case COMMUNAUTE_EUROPEENNE = 'C';
    case ETRANGERE = 'E';
}
