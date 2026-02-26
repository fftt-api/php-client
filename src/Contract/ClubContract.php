<?php

declare(strict_types=1);

namespace FFTTApi\Contract;

use FFTTApi\Enum\TypeEquipe;
use FFTTApi\Model\Club\Club;
use FFTTApi\Model\Club\DetailClub;
use FFTTApi\Model\Club\Equipe;

interface ClubContract
{
    /**
     * Endpoint : xml_club_dep2.php
     * ---------------------------------------------------------
     * Renvoie une liste de clubs pour un département.
     *
     * @return array<array-key, Club> Ensemble des clubs du département
     */
    public function clubsParDepartement(string $departement): array;

    /**
     * Endpoint : xml_club_b.php
     * ---------------------------------------------------------
     * Renvoie une liste de clubs par rapport à un code postal.
     *
     * @return array<array-key, Club> Ensemble des clubs trouvés
     */
    public function clubsParCodePostal(string $codePostal): array;

    /**
     * Endpoint : xml_club_b.php
     * ---------------------------------------------------------
     * Renvoie une liste de clubs par rapport à une ville.
     *
     * @return array<array-key, Club> Ensemble des clubs trouvés
     */
    public function clubsParVille(string $ville): array;

    /**
     * Endpoint : xml_club_b.php
     * ---------------------------------------------------------
     * Renvoie une liste de clubs par rapport à un nom.
     *
     * @return array<array-key, Club> Ensemble des clubs trouvés
     */
    public function clubsParNom(string $nom): array;

    /**
     * Endpoint : xml_club_detail.php
     * ---------------------------------------------------------
     * Renvoie le détail pour un club.
     *
     * @return ?DetailClub Club si trouvé
     */
    public function detailClub(string $code, ?string $idEquipe = null): ?DetailClub;

    /**
     * Endpoint : xml_equipe.php
     * ---------------------------------------------------------
     * Renvoie une liste des équipes d’un club.
     *
     * @return array<array-key, Equipe> Ensemble des équipes trouvées
     */
    public function equipesClub(string $code, TypeEquipe $typeEquipe): array;
}
