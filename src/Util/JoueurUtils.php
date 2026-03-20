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
        if (preg_match('/^\d+$/', $classement)) {
            return [
                'numero' => null,
                'points' => (int)$classement,
                'sexe' => null
            ];
        }

        $regex = '/^(?:N°\s*(?<numero>\d+)\D+)?(?<sexe>[MF])\s*(?<points>\d+)/u';

        preg_match($regex, $classement, $matches);

        return [
            'numero' => isset($matches['numero']) && $matches['numero'] !== '' ? (int)$matches['numero'] : null,
            'sexe' => ValueTransformer::nullOrEnum($matches['sexe'], Sexe::class),
            'points' => (float)$matches['points'],
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
