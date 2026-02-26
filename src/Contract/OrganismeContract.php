<?php

declare(strict_types=1);

namespace FFTTApi\Contract;

use FFTTApi\Enum\TypeOrganisme;
use FFTTApi\Model\Organisme\Organisme;

interface OrganismeContract
{
    /**
     * Endpoint : xml_organisme.php
     * ---------------------------------------------------------
     * Renvoie une liste des organismes.
     *
     * @return array<array-key, Organisme> Ensemble des organismes répondant au type
     */
    public function organismesParType(TypeOrganisme $orgType): array;

    /**
     * Endpoint : xml_organisme.php
     * ---------------------------------------------------------
     * Cherche un organisme par son type et son identifiant.
     *
     * @return ?Organisme Organisme (si trouvé)
     */
    public function organisme(string $code): ?Organisme;

    /**
     * Endpoint : xml_organisme.php
     * ---------------------------------------------------------
     * Cherche les organismes dépendants de l'organisme donné.
     *
     * @return array<array-key, Organisme> Organismes enfants
     */
    public function organismesEnfants(string $code): array;
}
