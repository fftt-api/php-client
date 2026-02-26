<?php

declare(strict_types=1);

namespace FFTTApi\Enum;

enum Diplome: string
{
    /** Diplômes d'arbitrage */
    case ARBITRE_DE_CLUB = 'AC';
    case ARBITRE_REGIONAL = 'AR';
    case ARBITRE_REGIONAL_THEORIQUE = 'ART';
    case ARBITRE_NATIONAL = 'AN';
    case ARBITRE_NATIONAL_THEORIQUE = 'ANT';
    case ARBITRE_INTERNATIONAL = 'AI';
    case ARBITRE_INTERNATIONAL_THEORIQUE = 'AIT';

    /** Diplômes de juge-arbitrage */
    case JUGE_ARBITRE_PAR_EQUIPES = 'JA1';
    case JUGE_ARBITRE_CRITERIUM_FEDERAL = 'JA2';
    case JUGE_ARBITRE_EPREUVES_REGIONALES = 'JA3';
    case JUGE_ARBITRE_EPREUVES_NATIONALES = 'JAN';
    case JUGE_ARBITRE_EPREUVES_INTERNATIONALES = 'JAI';

    /** Diplômes techniques */
    case JEUNE_ANIMATEUR_FEDERAL = 'JAF';
    case JEUNE_ENTRAINEUR = 'JE';
    case ANIMATEUR_POLYVALENT_DE_CLUB = 'APC';
    case ENTRAINEUR_DEPARTEMENTAL = 'ED';
    case ENTRAINEUR_REGIONAL = 'ER';
    case INITIATEUR_DE_CLUB = 'IC';
    case ANIMATEUR_FEDERAL = 'AF';
    case ENTRAINEUR_FEDERAL = 'EF';
    case DEJEPS = 'DEJEPS';
    case DESJEPS = 'DESJEPS';
    case CQP = 'CQP';
    case BPJEPS = 'BPJEPS';
    case BREVET_ETAT_EDUCATEUR_SPORTIF_1 = 'BEES1';
    case BREVET_ETAT_EDUCATEUR_SPORTIF_2 = 'BEES2';
    case BREVET_ETAT_EDUCATEUR_SPORTIF_3 = 'BEES3';
    case PROFESSORAT_DE_SPORT = 'PS';

    /** Autres diplômes */
    case AGENT_DEVELOPPEMENT = 'AD';
    case SANS_DIPLOME = 'SANS';
}
