<?php

declare(strict_types=1);

namespace FFTTApi\Contract;

use FFTTApi\Enum\TypeEpreuve;
use FFTTApi\Model\Epreuve\Division;
use FFTTApi\Model\Epreuve\Epreuve;

interface EpreuveContract
{
    /**
     * Endpoint : xml_epreuve.php
     * ---------------------------------------------------------
     * Renvoie une liste des épreuves pour un organisme.
     *
     * @return array<array-key, Epreuve> Ensemble des épreuves trouvées
     */
    public function rechercherEpreuves(int $organizationId, TypeEpreuve $contestType): array;

    /**
     * Endpoint : xml_division.php
     * ---------------------------------------------------------
     * Renvoie une liste des divisions pour une épreuve donnée.
     *
     * @return array<array-key, Division> Ensemble des divisions trouvées
     */
    public function rechercherDivisionsPourEpreuve(
        int         $organizationId,
        int         $contestId,
        TypeEpreuve $contestType
    ): array;
}
