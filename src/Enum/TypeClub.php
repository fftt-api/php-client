<?php

declare(strict_types=1);

namespace FFTTApi\Enum;

enum TypeClub: string
{
    case CORPORATIF = 'C';
    case LIBRE = 'L';
    case MIXTE = 'M';
    case VIRTUEL = 'V';
    case AUTRE = '';
}
