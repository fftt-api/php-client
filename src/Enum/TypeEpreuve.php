<?php

declare(strict_types=1);

namespace FFTTApi\Enum;

enum TypeEpreuve: string
{
    case CHAMPIONNAT_DE_FRANCE_PAR_EQUIPES = 'E';
    case AUTRE_EPREUVE_PAR_EQUIPES = 'H';
    case AUTRE_EPREUVE_INDIVIDUELLE = 'I';
    case CRITERIUM_FEDERAL = 'C';
}
