<?php

declare(strict_types=1);

namespace FFTTApi\Enum;

enum CategorieLicenceAdministrative: string
{
    case POUSSIN = 'P';

    case BENJAMIN_1 = 'B1';
    case BENJAMIN_2 = 'B2';

    case MINIME_1 = 'M1';
    case MINIME_2 = 'M2';

    case CADET_1 = 'C1';
    case CADET_2 = 'C2';

    case JUNIOR_1 = 'J1';
    case JUNIOR_2 = 'J2';
    case JUNIOR_3 = 'J3';
    case JUNIOR_4 = 'J4';

    case SENIOR = 'S';

    case VETERAN_40 = 'V40';
    case VETERAN_45 = 'V45';
    case VETERAN_50 = 'V50';
    case VETERAN_55 = 'V55';
    case VETERAN_60 = 'V60';
    case VETERAN_65 = 'V65';
    case VETERAN_70 = 'V70';
    case VETERAN_75 = 'V75';
    case VETERAN_80 = 'V80';
    case VETERAN_85 = 'V85';
    case VETERAN_90 = 'V90';
}
