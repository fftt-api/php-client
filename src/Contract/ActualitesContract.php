<?php

declare(strict_types=1);

namespace FFTTApi\Contract;

use FFTTApi\Model\Divers\Actualite;

interface ActualitesContract
{
    /**
     * Endpoint : xml_new_actu.php
     * ---------------------------------------------------------
     * Renvoie le flux d’actualités de la FFTT.
     *
     * @return array<array-key, Actualite> Ensemble des actualités
     */
    public function fluxActualitesFederation(): array;
}
