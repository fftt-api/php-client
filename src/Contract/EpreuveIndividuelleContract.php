<?php

declare(strict_types=1);

namespace FFTTApi\Contract;

use FFTTApi\Model\Epreuve\Individuelle\Classement;
use FFTTApi\Model\Epreuve\Individuelle\Groupe;
use FFTTApi\Model\Epreuve\Individuelle\Partie;

interface EpreuveIndividuelleContract
{
    /**
     * Endpoint : xml_result_indiv.php
     * ---------------------------------------------------------
     * Renvoie les différents groupes d’une épreuve individuelle.
     *
     * @return array<array-key, Groupe> Ensemble des groupes trouvés
     */
    public function rechercherGroupes(int $epreuveId, int $divisionId): array;

    /**
     * Endpoint : xml_result_indiv.php
     * ---------------------------------------------------------
     * Renvoie les différentes parties d’un tour d'une épreuve individuelle.
     *
     * @return array<array-key, Partie> Ensemble des parties trouvées
     */
    public function recupererParties(int $epreuveId, int $divisionId, ?int $groupeId = null): array;

    /**
     * Endpoint : xml_result_indiv.php
     * ---------------------------------------------------------
     * Renvoie le classement d’un tour d'une épreuve individuelle.
     *
     * @return array<array-key, Classement> Ensemble des classements trouvés
     */
    public function recupererClassement(int $epreuveId, int $divisionId, ?int $groupeId = null): array;

    /**
     * Endpoint : xml_res_cla.php
     * ---------------------------------------------------------
     * Renvoie le classement général d’une division du critérium fédéral.
     *
     * @return array<array-key, Classement> Ensemble des classements trouvés
     */
    public function recupererClassementCriterium(int $divisionId): array;
}
