<?php

declare(strict_types=1);

namespace FFTTApi\Util;

use FFTTApi\Enum\Sexe;

final class JoueurUtils
{
    /**
     * @return array{numero?: int, sexe?: Sexe, points?: float}
     */
    public static function parseClassementJoueur(string $classement): array
    {
        // Pattern 1: 1897 (just points)
        if (preg_match('/^\d+$/', $classement)) {
            return [
                'numero' => null,
                'sexe' => null,
                'points' => (float)$classement,
            ];
        }

        // Pattern 2: N°231- M 2485pts
        if (preg_match('/^N°(?<numero>\d+)\D+(?<sexe>[MF])\s*(?<points>\d+)/u', $classement, $matches)) {
            return [
                'numero' => (int)$matches['numero'],
                'sexe' => ValueTransformer::nullOrEnum($matches['sexe'], Sexe::class),
                'points' => (float)$matches['points'],
            ];
        }

        // Pattern 3: M 972pts
        if (preg_match('/^(?<sexe>[MF])\s*(?<points>\d+)/u', $classement, $matches)) {
            return [
                'numero' => null,
                'sexe' => ValueTransformer::nullOrEnum($matches['sexe'], Sexe::class),
                'points' => (float)$matches['points'],
            ];
        }

        // Pattern 4: N174 - 2584
        if (preg_match('/^N(?<numero>\d+)\s*\D+\s*(?<points>\d+)/u', $classement, $matches)) {
            return [
                'numero' => (int)$matches['numero'],
                'sexe' => null,
                'points' => (float)$matches['points'],
            ];
        }

        return [
            'numero' => null,
            'sexe' => null,
            'points' => null,
        ];
    }

    /**
     * Séparer le nom et prénom d'un joueur lorsque l'API les retourne dans
     * une seule et même chaîne de caractères.
     *
     * @return array{0: string, 1: string} Tableau contenant le nom (index 0) et le prénom (index 1)
     */
    public static function separerNomPrenom(string $nomPrenom): array
    {
        /**
         * Les expressions régulières sont récupérées depuis un repository tiers.
         * @see https://github.com/alamirault/fftt-api-src/blob/main/src/Service/NomPrenomExtractor.php
         */
        $result = preg_match(
            pattern: "/^(?<nom>[A-ZÀ-Ý]+(?:[\s'\-]*[A-ZÀ-Ý]+)*)\s(?<prenom>[A-ZÀ-Ý][a-zà-ÿ]*(?:[\s'\-]*[A-ZÀ-Ý][a-zà-ÿ]*)*)$/",
            subject: preg_replace(['/\s+/', '/-+/'], [' ', '-'], $nomPrenom) ?? '',
            matches: $matches,
        );

        if ($result !== 1) {
            return ['', ''];
        }

        return [$matches['nom'], $matches['prenom']];
    }
}
