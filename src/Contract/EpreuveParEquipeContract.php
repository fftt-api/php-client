<?php

declare(strict_types=1);

namespace FFTTApi\Contract;

use FFTTApi\Model\Epreuve\ParEquipes\Poule\EquipePoule;
use FFTTApi\Model\Epreuve\ParEquipes\Poule\Poule;
use FFTTApi\Model\Epreuve\ParEquipes\Rencontre\DetailRencontre;
use FFTTApi\Model\Epreuve\ParEquipes\Rencontre\Rencontre;

interface EpreuveParEquipeContract
{
    /**
     * Endpoint : xml_result_equ.php
     * ---------------------------------------------------------
     * Renvoie la liste des poules d'une division de championnat
     * par équipes.
     *
     * @return array<array-key, Poule> Ensemble des poules trouvées
     */
    public function poulesPourDivision(int $divisionId): array;

    /**
     * Endpoint : xml_result_equ.php
     * ---------------------------------------------------------
     * Renvoie la liste des rencontres d'une poule de championnat
     * par équipes.
     *
     * @return array<array-key, Rencontre> Ensemble des rencontres trouvées
     */
    public function rencontresPourPoule(int $divisionId, ?int $pouleId = null): array;

    /**
     * Endpoint : xml_result_equ.php
     * ---------------------------------------------------------
     * Renvoie les équipes d'une poule de championnat par équipes
     * dans l'ordre de la poule.
     *
     * @return array<array-key, EquipePoule> Ensemble des équipes trouvées
     */
    public function ordrePoule(int $divisionId, ?int $pouleId = null): array;

    /**
     * Endpoint : xml_result_equ.php
     * ---------------------------------------------------------
     * Renvoie le classement d'une poule de championnat par équipes.
     *
     * @return array<array-key, EquipePoule> Ensemble des classements trouvés
     */
    public function classementPoule(int $divisionId, ?int $pouleId = null): array;

    /**
     * Endpoint : xml_chp_renc.php
     * ---------------------------------------------------------
     * Renvoie les informations détaillées d’une rencontre.
     *
     * @param array{
     *     is_retour: bool,
     *     phase: int,
     *     res_1: int,
     *     res_2: int,
     *     equip_1: string,
     *     equip_2: string,
     *     equip_id1: int,
     *     equip_id2: int
     * } $extraParams
     *
     * @return ?DetailRencontre Détails de la rencontre si trouvée
     */
    public function detailRencontre(int $rencontreId, array $extraParams): ?DetailRencontre;
}
