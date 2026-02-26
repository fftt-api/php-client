<?php

declare(strict_types=1);

namespace FFTTApi\Enum;

enum TypeLicence: string
{
    case COMPETITION = 'T';
    case LOISIR = 'P';
    case EVENEMENTIELLE = 'E';
    case DIRIGEANT = 'A';
    case DECOUVERTE = 'I';
    case LIBERTE = 'L';
    case AUTRE = '';
}
