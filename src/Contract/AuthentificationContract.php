<?php

declare(strict_types=1);

namespace FFTTApi\Contract;

interface AuthentificationContract
{
    /**
     * Endpoint : xml_initialisation.php
     * ---------------------------------------------------------
     * Vérifie et crée un nouvel utilisateur pour l'application.
     *
     * @return bool Accès autorisé ou non
     */
    public function authentifier(): bool;
}
